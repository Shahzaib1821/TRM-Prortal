<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => [
                        'email.required' => 'Email is required',
                        'email.email' => 'Email must be a valid email address',
                        'email.exists' => 'Email does not exist',
                        'password.required' => 'Password is required',
                        'password.current' => 'The password is incorrect',
                    ],
                    'errors' => $validateUser->errors()
                ]);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => [
                        'invalid' => 'Invalid email or password',
                    ],
                ]);
            }            

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function dashboard()
    {
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'User Information',
            'data' => $userData,
            'id' => auth()->user()->id,
        ]);
    }

        public function logout(Request $request){
            $request->user()->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
                'data' => [],
            ]);
        }
}
