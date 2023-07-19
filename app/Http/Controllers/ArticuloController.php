<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Audit;

class ArticuloController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-articulo|crear-articulo|editar-articulo|borrar-articulo')->only('index');
        $this->middleware('permission:crear-articulo', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-articulo', ['only' => ['edit', 'update']]);
        $this->middleware('permission:editar-articulo', ['only' => ['agre', 'agregar']]);
        $this->middleware('permission:borrar-articulo', ['only' => ['destroy']]);
    }

    public function index()
    {
        $articulos = Articulo::paginate(5);
        return view('articulos.index', compact('articulos'));
    }


    public function create()
    {
        return view('articulos.crear');
    }


    public function store(Request $request)
    {
        request()->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'stock' => 'required',
        ]);

        $articulo = Articulo::create($request->all());

        $this->createAudit('creación', null, $articulo->toArray());

        return redirect()->route('articulos.index');
    }
    public function show($idS)
    {
        //
    }
    public function edit(Articulo $articulo)
    {
        return view('articulos.editar', compact('articulo'));
    }

    public function modificar(Articulo $articulo)
    {
        return view('articulos.modificar', compact('articulo'));
    }

    public function actualizar(Request $request, Articulo $articulo)
    {
        request()->validate([
            'nombre' => 'required',
            'cantidad' => 'required',
        ]);
    
        $oldData = $articulo->toArray();
    
        $nuevoStock = $articulo->stock + $request->cantidad;
        $articulo->update(['stock' => $nuevoStock]);
    
        $newData = $articulo->toArray();
    
        $this->createAudit('actualización-cantidad', $oldData, $newData);
    
        return redirect()->route('articulos.index');
    }
    

    public function update(Request $request, Articulo $articulo)
    {
        request()->validate([
            'nombre' => 'required',
            'precio' => 'required',
        ]);

        $oldData = $articulo->toArray();
        $articulo->update($request->all());
        $newData = $articulo->toArray();

        $this->createAudit('actualización', $oldData, $newData);

        return redirect()->route('articulos.index');
    }


    public function destroy(Articulo $articulo)
    {
        $oldData = $articulo->toArray();

        $articulo->delete();

        $this->createAudit('eliminación', $oldData);

        return redirect()->route('articulos.index');
    }
    private function createAudit($action, $oldData = null, $newData = null)
    {
        Audit::create([
            'user_id' => auth()->user()->id,
            'action' => $action,
            'table_name' => 'articulos',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
