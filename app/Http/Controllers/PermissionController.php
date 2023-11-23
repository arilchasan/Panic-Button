<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.permissions.permission', [
            'permissions' => Permission::all(),
            'role' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create', [
            'permissions' => Permission::all(),
            'role' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'guard_name' => 'required'
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal menambahkan Permissions');
        } else {
            $permission = Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);
            if ($request->has('roles')) {
                $roles = $request->input('roles');
                $permission->syncRoles($roles);
            }

            return redirect('/dashboard/permission/all')->with('success', 'Berhasil menambahkan Permissions');
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
    public function edit(string $id)
    {

        return view('admin.permissions.edit', [
            'permission' => Permission::find($id),
            'role' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'guard_name' => 'required'
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal mengubah Permissions');
        } else {
            $permission = Permission::find($id);
            $permission->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);
            if ($request->has('roles')) {
                $roles = $request->input('roles');
                $permission->syncRoles($roles);
            }

            return redirect('/dashboard/permission/all')->with('success', 'Berhasil mengubah Permissions');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $permission = Permission::find($id);

         if($permission){
               $permission->delete();
               return redirect('/dashboard/permission/all')->with('success', 'Berhasil menghapus Permissions');
         } else {
                return redirect('/dashboard/permission/all')->with('errors', 'Gagal menghapus Permissions');
         }

    }
}
