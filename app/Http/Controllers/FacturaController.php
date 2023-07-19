<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Audit;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class FacturaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-factura|crear-factura|editar-factura|borrar-factura')->only('index');
        $this->middleware('permission:crear-factura', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-factura', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-factura', ['only' => ['destroy']]);
    }

    public function index()
    {
        $facturas = Factura::paginate(5);
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes desde la base de datos
        return view('facturas.crear', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Validar los campos del formulario de creación de facturas
        $request->validate([
            'cedula' => 'required',
            'id_usuario' => 'required',
            'fecha_fac' => 'required',
            'subtotal_fac' => 'required',
            'iva' => 'required',
            'total' => 'required',
        ]);

        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => 'creación',
            'table_name' => 'facturas',
            'ip_address' => request()->ip(), // Agregar la dirección IP de la solicitud
            'created_at' => now(),
        ]);

        $factura = Factura::create($request->all());

        return redirect()->route('facturas.index');
    }

    public function edit(Factura $factura)
    {
        return view('facturas.editar', compact('factura'));
    }

    public function update(Request $request, Factura $factura)
    {
        // Validar los campos del formulario de edición de facturas
        $request->validate([
            'cedula' => 'required',
            'id_usuario' => 'required',
            'fecha_fac' => 'required',
            'subtotal_fac' => 'required',
            'iva' => 'required',
            'total' => 'required',
        ]);

        $oldData = $factura->toArray();
        $factura->update($request->all());
        $newData = $factura->toArray();

        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => 'actualización',
            'table_name' => 'facturas',
            'ip_address' => request()->ip(), // Agregar la dirección IP de la solicitud
            'created_at' => now(),
        ]);

        return redirect()->route('facturas.index');
    }

    public function destroy(Factura $factura)
    {
        $oldData = $factura->toArray();
        $facturaId = $factura->getAttribute('id_factura');
        DB::table('facturas')->where('id_factura', $facturaId)->delete();

        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => 'eliminación',
            'table_name' => 'facturas',
            'ip_address' => request()->ip(), // Agregar la dirección IP de la solicitud
            'created_at' => now(),
        ]);

        return redirect()->route('facturas.index');
    }

    public function generatePDF()
    {
        $facturas = Factura::all();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = view('facturas.pdf', compact('facturas'))->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('reporte_facturas.pdf');
    }
}
