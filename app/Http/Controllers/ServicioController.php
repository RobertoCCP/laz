<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Audit;

class ServicioController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:ver-servicio|crear-servicio|editar-servicio|borrar-servicio')->only('index');
         $this->middleware('permission:crear-servicio', ['only' => ['create','store']]);
         $this->middleware('permission:editar-servicio', ['only' => ['edit','update']]);
         $this->middleware('permission:borrar-servicio', ['only' => ['destroy']]);
    }
   
    public function index()
    {
        $servicios = Servicio::paginate(5);
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.crear');
    }

    public function store(Request $request)
    {
        request()->validate([
            'nombreServicio' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
        ]);

        $servicio = Servicio::create($request->all());

        $this->createAudit('creación', null, $servicio->toArray());

        return redirect()->route('servicios.index');
    }

    public function show($idS)
    {
        //
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.editar', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        request()->validate([
            'nombreServicio' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
        ]);

        $oldData = $servicio->toArray();
        $servicio->update($request->all());
        $newData = $servicio->toArray();

        $this->createAudit('actualización', $oldData, $newData);

        return redirect()->route('servicios.index');
    }

    public function destroy(Servicio $servicio)
    {
        $oldData = $servicio->toArray();

        $servicio->delete();

        $this->createAudit('eliminación', $oldData);

        return redirect()->route('servicios.index');
    }

    private function createAudit($action, $oldData = null, $newData = null)
    {
        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => $action,
            'table_name' => 'servicios',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'ip_address' => request()->ip(), // Agregar la dirección IP de la solicitud
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
