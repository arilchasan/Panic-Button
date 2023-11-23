<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.role.role', [
            'role' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required'
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('error', 'Gagal menambahkan Role');
        } else {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);
            if ($request->has('permissions')) {
                $permissions = $request->input('permissions');
                $role->syncPermissions($permissions);
            }

            return redirect('/dashboard/role/all')->with('success', 'Berhasil menambahkan Role');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $name)
    {
        $permissions = Permission::all();
        $role = Role::where('name', $name)->first();
        $old_guard = old('guard_name', $role->guard_name);
        $guard_name = ['web', 'admin'];
        $old_permissions = old('name', $role->permissions);
        return view('admin.role.edit', [
            'permissions' => $permissions,
            "role" => $role,
            'old_guard' => $old_guard,
            'guard_name' => $guard_name,
            'old_permissions' => $old_permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $name)
    {
        $role = Role::where('name', $name)->first();

        $rules = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id,
            'guard_name' => 'required',
        ]);

        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal mengupdate Role');
        } else {
            $role->name = $request->name;
            $role->guard_name = $request->guard_name;
            $role->save();

            if ($request->has('permissions')) {
                $permissions = $request->input('permissions');
                $role->syncPermissions($permissions);
            }

            return redirect('/dashboard/role/all')->with('success', 'Berhasil mengupdate Role');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return redirect('/dashboard/role/all')->with('success', 'Berhasil menghapus Role');
        } else {
            return redirect('/dashboard/role/all')->with('errors', 'Role tidak ditemukan');
        }
    }
}
