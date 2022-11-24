<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function register(Request $request)
    // {
    //     $fields = $request->validate([
    //         'first_name' => 'required|string',
    //         'last_name' => 'required|string',
    //         'mobile_number' => 'required|string|unique:users,mobile_number|min:13|max:13',
    //         // 'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::create([
    //         'mobile_number' => $fields['mobile_number'],
    //         'password' => bcrypt($fields['password'])
    //     ]);

    //     $user_info = UserInfo::create([
    //         'user_id' => $user->id, 
    //         'first_name' => $fields['first_name'],
    //         'last_name' => $fields['last_name'],
    //         'email' => $request->email,
    //     ]);

    //     $token = $user->createToken('myapptoken', ['user'])->plainTextToken;

    //     $reponse = [
    //         'message' => 'User created.',
    //         'user' => $user->load('userInfo'),
    //         'token' => $token
    //     ];

    //     return response($reponse, 201);
    // }

    // public function login(Request $request)
    // {
    //     $fields = $request->validate([
    //         'mobile_number' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::firstWhere('mobile_number', $fields['mobile_number']);

    //     if (!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Invalid Credentials.',
    //             'errors' => [
    //                 'credentials' => 'User not found or wrong password.'
    //             ]
    //         ], 401);
    //     }

    //     $token = $user->createToken('myapptoken', ['user'])->plainTextToken;

    //     $reponse = [
    //         'message' => 'Successfully login.',
    //         'user' => $user->load('userInfo'),
    //         'token' => $token
    //     ];

    //     return response($reponse, 200);
    // }

    // public function logout(Request $request)
    // {
    //     if (auth()->user()->tokenCan('user')) {
    //         auth()->user()->tokens()->delete();

    //         $response = [
    //             'message' => 'Logged out.'
    //         ];

    //         return response($response, 200);
    //     } else {
    //         $response = [
    //             'message' => 'Unauthorized.'
    //         ];

    //         return response($response, 403);
    //     }
    // }
}
