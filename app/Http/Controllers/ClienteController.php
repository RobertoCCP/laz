<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Audit;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

class ClienteController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|borrar-cliente')->only('index');
         $this->middleware('permission:crear-cliente', ['only' => ['create','store']]);
         $this->middleware('permission:editar-cliente', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-cliente', ['only' => ['destroy']]);
    }
    
    public function index()
    {       
         $clientes = Cliente::paginate(5);
         return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.crear');
    }

    public function store(Request $request)
    {
        request()->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        $cliente = Cliente::create($request->all());

        $this->createAudit('creación', null, $cliente->toArray());

        return redirect()->route('clientes.index');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.editar', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        request()->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        $oldData = $cliente->toArray();
        $cliente->update($request->all());
        $newData = $cliente->toArray();

        $this->createAudit('actualización', $oldData, $newData);

        return redirect()->route('clientes.index');
    }

    public function destroy(Cliente $cliente)
    {
        $oldData = $cliente->toArray();

        $cliente->delete();

        $this->createAudit('eliminación', $oldData);

        return redirect()->route('clientes.index');
    }

    private function createAudit($action, $oldData = null, $newData = null)
    {
        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => $action,
            'table_name' => 'clientes',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function generatePDF()
    {
        $clientes = Cliente::all();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        $dompdf = new Dompdf($pdfOptions);
        $html = view('clientes.pdf', compact('clientes'))->render();
        $dompdf->loadHtml($html);
        $dompdf->render();
    
        $dompdf->stream('reporte_clientes.pdf');
    }
}
