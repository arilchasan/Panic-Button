<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $contact = Contact::all();
        if($request->wantsJson()) {
            if($contact->isEmpty()){
                return $this->notFoundResponse(null);
            } else {
                return $this->getSuccessResponse(['contact' => $contact], "Berhasil mendapatkan data kontak");
            }
        }
        return view("admin.contact.contact", [
            "contact" => $contact,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        if ($rules->fails()) {
            if($request->wantsJson()){
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan Informasi');
        } else {
            $contact = Contact::create([
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
            ]);
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Create Contact', $contact);
            }
            return redirect('/dashboard/contact/all')->with('success', 'Berhasil menambahkan Kontak');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::where("name", $id)->first();
        return view("admin.contact.edit", [
            "contact" => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        if ($rules->fails()) {
            if($request->wantsJson()){
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui Kontak');
        } else {
            $contact = Contact::where("name", $id)->first();
            if(! $contact) {
                return $this->notFoundResponse(null);
            }
            $contact->update([
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
            ]);
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Update Contact', $contact);
            }
            return redirect('/dashboard/contact/all')->with('success', 'Berhasil memperbarui Kontak');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact,$id, Request  $request)
    {
        $contact = Contact::where("name", $id)->first();
        if($contact){
            $contact->delete();
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Delete Contact', $contact);
            } else {
                return redirect('/dashboard/contact/all')->with('success', 'Berhasil menghapus Kontak');
            }
        } else {
            if ($request->wantsJson()) {
                return $this->notFoundResponse(null);
            } else  {
                return redirect('/dashboard/contact/all')->with('error', 'Gagal menghapus Kontak');
            }
        }
    }
}
