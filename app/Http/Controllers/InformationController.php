<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $info = Information::all();
        if ($request->wantsJson()) {
            if ($info->isEmpty()) {
                return $this->notFoundResponse(['information' => null]);
            }
            return $this->getSuccessResponse(['information' => $info]);
        }
        return view('admin.information.information', [
            'info' => $info,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'tittle' => 'required|unique:information,tittle',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('error', 'Gagal menambahkan Informasi');
        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::Random(7) . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img_information/'), $imageName);
            }
            //$description = strip_tags($request->input('description'));
            $info = Information::create([
                'tittle' => $request->tittle,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            return redirect('/dashboard/information/all')->with('success', 'Berhasil menambahkan Informasi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $information, $id, Request $request)
    {
        $info = Information::where('tittle', $id)->first();

        if ($request->wantsJson()) {
            if ($info) {
                return $this->getSuccessResponse(['information' => $info]);
            }
            else {
                return $this->notFoundResponse(null);
            }
        }

        $description = htmlspecialchars_decode($info->description);
        return view('admin.information.detail', [
            'info' => $info,
            'description' => $description,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information, $id)
    {
        $info = Information::where('tittle', $id)->first();
        return view('admin.information.edit', [
            'info' => $info,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Information $information, $tittle)
    {
        $rules = Validator::make($request->all(), [
            'tittle' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($rules->fails()) {
            return redirect()->back()->with('error', 'Gagal mengubah Informasi');
        } else {
            $info = Information::where('tittle', $tittle)->first();
            $imageName = $info->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::Random(7) . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img_information/'), $imageName);
            }
            //$description = strip_tags($request->input('description'));
            $info->update([
                'tittle' => $request->tittle,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            return redirect('/dashboard/information/all')->with('success', 'Berhasil mengubah Informasi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information, $id)
    {
        $info = Information::find($id);
        if ($info) {
            $info->delete();
            return redirect('/dashboard/information/all')->with('success', 'Berhasil menghapus Informasi');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus Informasi');
        }
    }
}
