<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('front.Auth.Login');
    }

    public function showRegisterForm()
    {
        return view('front.Auth.Register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:registerd_users',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'This email has already been registered.',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));

        try {
            UsersModel::create($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user. ' . $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
        // $request->validate([
        //     'name' => ['required', 'string', 'max:100'],
        //     'email' => ['required', 'string', 'email', 'max:100', 'unique:registerd_users'],
        //     'password' => ['required', 'string', 'min:5'],
        // ]);

        // $user = \App\Models\UsersModel::create([
        //     'name' => $request->name,
        //     'company' => $request->company,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'role' => $request->role,
        //     'active' => $request->active,
        // ]);

        // Auth::login($user);

        // return redirect()->route('dashboard');
    }


    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:5'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
