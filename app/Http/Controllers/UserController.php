<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('admin.user.user', [
            'user' => $user,
        ]);
    }
    public function alluser()
    {
        $users = User::all();
        if ($users) {
            if($users->isEmpty()) {
                return $this->notFoundResponse(['user' => 'User Data is Empty']);
            } else {
                return $this->getSuccessResponse(['user' => $users]);
            }
        } else {
            return $this->notFoundResponse('User not found');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal manambahkan data user');
        } else {
            $avatarName = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = Str::Random(7) . '_' . $avatar->get();
                $avatar->move(public_path('assets/profile/'), $avatarName);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'avatar' => $avatarName,
                'created_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ]);
            return redirect('dashboard/user/all')->with('success', 'Berhasil manambahkan data user');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $user = User::where('name',  $name)->first();
        return view('admin.user.detail', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();
        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($rules->fails()) {
            return redirect()->back()->with('errors', 'Gagal mengubah data user');
        } else {
            $user = User::find($request->id);
            if (!$user) {
                return redirect()->back()->with('errors', 'Gagal mengubah data user');
            } else {
                // File::delete(public_path('assets/profile/' . $user->avatar));

                $avatarName = $user->avatar;
                if ($request->hasFile('avatar')) {
                    File::delete(public_path('assets/profile/' . $avatarName));
                    $avatar = $request->file('avatar');
                    $avatarName = Str::Random(7) . '_' . $avatar->getClientOriginalName();
                    $avatar->move(public_path('assets/profile/'), $avatarName);
                }

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'avatar' => $avatarName,
                    'updated_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                ]);
                return redirect('dashboard/user/all')->with('success', 'Berhasil mengubah data user');
            }
        }
    }
    public function profile(Request $request)
    {
        $user = $request->user();
        $toko = Toko::where('user_id', $user->id)->get();
        if ($user) {
            if ($toko->isEmpty()) {
                return $this->getSuccessResponse(['user' => $user]);
            } else {
                return $this->getSuccessResponse(['user' => $user]);
            }
        } else {
            return $this->notFoundResponse('User not found');
        }
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $rules = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($rules->fails()) {
            return $this->errorValidationResponse($rules);
        }
        $avatarName = $user->avatar;
        if ($request->hasFile('avatar')) {
            File::delete(public_path('assets/profile/' . $avatarName));
            $avatar = $request->file('avatar');
            $avatarName = Str::Random(7) . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('assets/profile/'), $avatarName);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $avatarName,
            'updated_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);
        if ($user) {
            return $this->postSuccessResponse('Successfully Update Profile', $user);
        } else {
            return $this->notFoundResponse(
                'User not found',
            );
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('dashboard/user/all')->with('success', 'Berhasil menghapus user');
        } else {
            return redirect('dashboard/user/all')->with('error', 'Gagal menghapus user');
        }
    }

    public function history(string $name)
    {
        $user = User::where('name', $name)->first();
        $payment = Payment::where('user_id', $user->id)->get();
        return view('admin.user.history', [
            'user' => $user,
            'payment' => $payment,
        ]);
    }

    public function detailHistory(string $name, int $id)
    {
        $user = User::where('name', $name)->first();
        $payment = Payment::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        return view('admin.user.detail_history', [
            'user' => $user,
            'payment' => $payment,
        ]);
    }

    public function daftarToko($name)
    {
        $user = User::where('name', $name)->first();
        $toko = Toko::where('user_id', $user->id)->get();
        return view('admin.user.daftartoko', [
            'user' => $user,
            'toko' => $toko,
        ]);
    }

    public function detailToko($name, $id)
    {
        $user = User::where('name', $name)->first();
        $toko = Toko::where('user_id', $user->id)
            ->where('id',  $id)
            ->first();
        return view('admin.user.detailtoko', [
            'user' => $user,
            'toko' => $toko,
        ]);
    }
}
