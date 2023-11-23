<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect('/dashboard/all')->with('success', 'Berhasil Login sebagai' . ' ' . Auth::guard('admin')->user()->name);
        } else {
            return redirect()->back()->with('error', 'Login Gagal, Email atau password salah');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return $this->postSuccessResponse('User Registration Success', $user);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), null, 500);
        };
    }

    public function loginUser(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required',
                'fcm_token' => 'required'
            ]);

            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                return $this->failedResponse('Phone number not registered', null, 400);
            }
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->postSuccessResponse('Login Success', [
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), null, 500);
        }
    }

    public function logoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->postSuccessResponse('Logout Success', $request->user());
    }
}
