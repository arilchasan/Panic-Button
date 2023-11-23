<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subs = Subscription::all();
        return view('admin.subs.subscriptions', [
            'subs' => $subs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subs.create',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all() , [
            'subscription_name' => 'required',
            'price_installation' => 'required',
            'maintenance_price' => 'required',
            'day' => 'required',
        ]);
        if ($rules->fails()) {
            return redirect()->back()->withErrors($rules)->withInput();
        } else {
           $subs = Subscription::create([
                'subscription_name' => $request->subscription_name,
                'price_installation' => $request->price_installation,
                'maintenance_price' => $request->maintenance_price,
                'day' => $request->day,
            ]);
            return redirect('/dashboard/subscriptions/index')->with('success', 'Berhasil menambahkan Subscription');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription , $id)
    {
        $subs = Subscription::where('subscription_name', $id)->first();
        return view('admin.subs.edit', [
            'subs' => $subs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription , $subscription_name)
    {
        $rules = Validator::make($request->all() , [
            'subscription_name' => 'required',
            'price_installation' => 'required',
            'maintenance_price' => 'required',
            'day' => 'required',
        ]);
        if ($rules->fails()) {
            return redirect()->back()->withErrors($rules)->withInput();
        } else {
            $subs = Subscription::where('subscription_name', $subscription_name)->first();
            $subs->subscription_name = $request->subscription_name;
            $subs->price_installation = $request->price_installation;
            $subs->maintenance_price = $request->maintenance_price;
            $subs->day = $request->day;
            $subs->save();
            return redirect('/dashboard/subscriptions/index')->with('success', 'Berhasil mengubah Subscription');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription , $id)
    {
        $subs = Subscription::find($id);

        if($subs) {
            $subs->delete();
            return redirect('/dashboard/subscriptions/index')->with('success', 'Berhasil menghapus Subscription');
        } else {
            return redirect('/dashboard/subscriptions/index')->with('error', 'Gagal menghapus Subscription');
        }
    }
}
