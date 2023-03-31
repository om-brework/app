<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function Register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone_number' => ['required', 'string', 'max:255'],
                'email' => ['required',  'max:255', 'email'],
                'password' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:255'],
                'have_sub_account' => ['string', 'max:255'],
                'parent_id' => ['integer']

            ]);
            $user = new User;
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->have_sub_account = $request->have_sub_account;
            $user->parent_id = $request->parent_id;
            $user->save();

            $dataUser = User::all();
            $response = [
                'user' => $dataUser,
                'message' => 'Data Loaded!'
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
    public function login(Request $request)
    {
        try {

            $credential = $request->validate([
                'email' => ['required', 'string'],
                'password' => ['required', 'string']
            ]);

            if (!Auth::attempt($credential)) {
                $data = ['message' => 'Authentication failed'];
                return response()->json($data, 500);
            }
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('app_token')->plainTextToken;
            $data = [
                'user' => $user,
                'token' => $token,
                'message' => 'Authenticated'
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
    public function getUser()
    {
        $user = User::all();
        return response()->json($user, 200);
    }
}
