<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use App\Models\Payment;
use App\Models\Province;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Regencies;
use App\Models\Information;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $toko = Toko::all();
        if ($request->wantsJson()) {
            if ($toko->isEmpty()) {
                return $this->notFoundResponse(['toko' => 'Store Data is Empty']);
            } else if ($toko) {
                return $this->getSuccessResponse(['toko' => $toko]);
            } else {
                return $this->getErrorResponse('Toko not found', 404);
            }
        }
        return view('admin.toko.toko', [
            'toko' => $toko
        ]);
    }

    public function home(Request $request)
    {
        $toko = Toko::where('user_id', $request->user()->id)->get();
        $info = Information::all();
        if ($request->wantsJson()) {
            if ($toko->isEmpty() && $info->isEmpty()) {
                return $this->notFoundResponse(['toko' => null, 'info' => null]);
            } else if ($info->isEmpty()) {
                return $this->getSuccessResponse(['toko' => $toko, 'info' => null]);
            } else if ($toko->isEmpty()) {
                return $this->getSuccessResponse(['toko' => null, 'info' => $info]);
            } else if ($toko) {
                return $this->getSuccessResponse(['toko' => $toko, 'info' => $info]);
            } else {
                return $this->notFoundResponse('Data not found');
            }
        }
        return view('admin.toko.home', [
            'toko' => $toko
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $toko = Toko::all();
        $province = Province::all();
        $regencies = Regencies::all();
        $districts = Districts::all();
        $villages = Villages::all();
        $subs = Subscription::all();
        $user = User::all();
        return view('admin.toko.create', [
            'toko' => $toko,
            'province' => $province,
            'regencies' => $regencies,
            'districts' => $districts,
            'villages' => $villages,
            'subs' => $subs,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'regencies_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'subsription_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            //'key' => 'required',
            'status_active' => 'required'
        ]);
        if ($rules->fails()) {
            if ($request->wantsJson()) {
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan data Panic Button');
        } else {
            $toko = Toko::create([
                'name' => $request->name,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'regencies_id' => $request->regencies_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'subsription_id' => $request->subsription_id,
                'user_id' => $request->user_id,
                'status' => $request->status,
                'key' => Str::random(10),
                'status_active' => $request->status_active
            ]);
            $subs = Subscription::where('id', $request->subsription_id)->first();
            Payment::create([
                'code_bill' => 'INV' . $toko->id . date('YmdHis'),
                'package_fee' =>  $subs->maintenance_price ,
                'installation_fee' => $subs->price_installation,
                'admin_fee' => 10000,
                'transaction_time' => date('Y-m-d H:i:s'),
                'payment_time' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'user_id' => $request->user_id,
                'subscription_id' => $request->subsription_id,
            ]);
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Create Store', $toko);
            }
            return redirect('/dashboard/store/all')->with('success', 'Berhasil menambahkan data Panic Button');
        }
    }


    public function addStore(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'regencies_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'subsription_id' => 'required',
            'status' => 'required',
            'status_active' => 'required'

        ]);
        if ($rules->fails()) {
            if ($request->wantsJson()) {
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan data Panic Button');
        } else {
            $user = $request->user();
            $user_id = $user->id;
            $toko = Toko::create([
                'name' => $request->name,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'regencies_id' => $request->regencies_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'subsription_id' => $request->subsription_id,
                'user_id' => $user_id,
                'status' => $request->status,
                'key' => Str::random(10),
                'status_active' => $request->status_active,
            ]);
            $subs = Subscription::where('id', $request->subsription_id)->first();
            Payment::create([
                'code_bill' => 'INV' . $toko->id .  Carbon::now('Asia/Jakarta')->format('YmdHis'),
                'package_fee' =>  $subs->maintenance_price ,
                'installation_fee' => $subs->price_installation,
                'admin_fee' => 10000,
                'transaction_time' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'payment_time' =>  Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'status' => 'pending',
                'user_id' => $user_id,
                'subscription_id' => $request->subsription_id,
            ]);
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Create Store', $toko);
            }
            return redirect('/dashboard/store/all')->with('success', 'Berhasil menambahkan data Panic Button');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Toko $toko, $id, Request $request)
    {
        $toko = Toko::where('name', $id)->first();
        if ($request->wantsJson()) {
            if ($toko) {
                return $this->getSuccessResponse(['toko' => $toko]);
            } else {
                return $this->notFoundResponse(['Toko not found']);
            }
        }
        return view('admin.toko.detail', [
            'toko' => $toko
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko, $id)
    {
        $toko = Toko::where('name', $id)->first();
        $province = Province::all();
        $regencies = Regencies::all();
        $districts = Districts::all();
        $villages = Villages::all();
        $subs = Subscription::all();
        $user = User::all();
        return view('admin.toko.edit', [
            'toko' => $toko,
            'province' => $province,
            'regencies' => $regencies,
            'districts' => $districts,
            'villages' => $villages,
            'subs' => $subs,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toko $toko, $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'regencies_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'subsription_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            //'key' => 'required',
            'status_active' => 'required'
        ]);
        if ($rules->fails()) {
            if ($request->wantsJson()) {
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal mengupdate data toko');
        } else {
            $toko = Toko::where('name', $id)->first();
            if (!$toko) {
                if ($request->wantsJson()) {
                    return $this->notFoundResponse(['Toko not found']);
                }
                return redirect()->back()->with('error', 'Gagal mengupdate data Panic Button');
            } else {
                $toko->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'province_id' => $request->province_id,
                    'regencies_id' => $request->regencies_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'subsription_id' => $request->subsription_id,
                    'user_id' => $request->user_id,
                    'status' => $request->status,
                    'key' => $request->filled('key') ? $request->key : $toko->key,
                    'status_active' => $request->status_active,
                ]);
                if ($request->wantsJson()) {
                    return $this->postSuccessResponse('Succesfully Update Store', $toko);
                }
                return redirect('/dashboard/store/all')->with('success', 'Berhasil mengupdate data Panic Button');
            }
        }
    }

    public function updateStore(Request $request, Toko $toko, $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'regencies_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'subsription_id' => 'required',
            'status' => 'required',
            //'key' => 'required',
            'status_active' => 'required'
        ]);
        if ($rules->fails()) {
            if ($request->wantsJson()) {
                return $this->errorValidationResponse($rules);
            }
            return redirect()->back()->with('error', 'Gagal mengupdate data Panic Button');
        } else {
            $toko = Toko::where('name', $id)->first();
            if (!$toko) {
                if ($request->wantsJson()) {
                    return $this->notFoundResponse(['Toko not found']);
                }
                return redirect()->back()->with('error', 'Gagal mengupdate data Panic Button');
            } else {
                $user = $request->user();
                $user_id = $user->id;
                $toko->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'province_id' => $request->province_id,
                    'regencies_id' => $request->regencies_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'subsription_id' => $request->subsription_id,
                    'user_id' => $user_id,
                    'status' => $request->status,
                    'key' => $request->filled('key') ? $request->key : $toko->key,
                    'status_active' => $request->status_active
                ]);
                if ($request->wantsJson()) {
                    return $this->postSuccessResponse('Succesfully Update Store', $toko);
                }
                return redirect('/dashboard/store/all')->with('success', 'Berhasil mengupdate data Panic Button');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko, $id, Request $request)
    {
        $toko = Toko::where('name', $id)->first();
        if ($toko) {
            $toko->delete();
            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Succesfully Delete Store', $toko);
            } else {
                return redirect()->back()->with('success', 'Berhasil menghapus data Panic Button');
            }
        } else {
            if ($request->wantsJson()) {
                return $this->notFoundResponse(['Toko not found']);
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus data Panic Button');
            }
        }
    }

    public function getRegencies(Request $request)
    {
        $idprovince = $request->idprovince;
        $regencies = Regencies::where('province_id', $idprovince)->get();
        $option = '<option value="">Pilih Kabupaten</option>';
        foreach ($regencies as $regency) {
            $option .= '<option value="' . $regency->id . '">' . $regency->name . '</option>';
        }
        echo $option;
        //return response()->json($regencies);
    }

    public function getDistrict(Request $request)
    {
        $idregencies = $request->idregencies;
        $districts = Districts::where('regency_id', $idregencies)->get();
        $option = '<option value="">Pilih Kecamatan</option>';
        foreach ($districts as $district) {
            $option .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }
        echo $option;
        //return response()->json($districts);
    }

    public function getVillage(Request $request)
    {
        $iddistrict = $request->iddistrict;
        $villages = Villages::where('district_id', $iddistrict)->get();
        $option = '<option value="">Pilih Desa</option>';
        foreach ($villages as $village) {
            $option .= '<option value="' . $village->id . '">' . $village->name . '</option>';
        }
        echo $option;
        //return response()->json($villages);
    }
}
