<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.list_admin.admin', [
            'admin' => Admin::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.list_admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal menambahkan data admin');
        } else {
            $admin = Admin::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);
            return redirect('/dashboard/admin/all')->with('success', 'Berhasil menambahkan data admin');
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

        return view('admin.list_admin.edit', [
            'admin' => Admin::find($id),
            'role' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal mengupdate data admin');
        } else {
            $admin = Admin::find($id);
            $admin->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);
            return redirect('/dashboard/admin/all')->with('success', 'Berhasil mengupdate data admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::find($id);
        $admin->delete();
        return redirect('/dashboard/admin/all')->with('success', 'Berhasil menghapus data admin');
    }
}
