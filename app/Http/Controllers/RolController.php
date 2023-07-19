<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only' => ['index']]);
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.crear', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        $this->createAuditEntry('creación', 'roles', $role->id);

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.editar', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        $this->createAuditEntry('edición', 'roles', $role->id);

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $this->createAuditEntry('eliminación', 'roles', $role->id);

        $role->delete();

        return redirect()->route('roles.index');
    }

    private function createAuditEntry($action, $table, $itemId)
    {
        $userId = Auth::user()->id;

        Audit::create([
            'user_id' => $userId,
            'action' => $action,
            'table_name' => $table,
            'item_id' => $itemId,
            'ip_address' => request()->ip(), // Agregar la dirección IP de la solicitud
        ]);
    }
}
