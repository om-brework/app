<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function Register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone_number' => ['required', 'string', 'max:255'],
                'email' => ['required',  'max:255', 'email'],
                'role' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],

            ]);
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();
            $userID = $user->id;

            $userLogin = new UserLogin;
            $userLogin->username = $request->username;
            $userLogin->password = Hash::make($request->password);
            $userLogin->user_id = $userID;
            $userLogin->save();

            $dataUser = User::with(['user_login'])->get();
            foreach ($dataUser as $a) {

                $dataToSend[] = array(
                    'id' => $a->id,
                    'first_name' => $a->first_name,
                    'last_name' => $a->last_name,
                    'phone_number' => $a->phone_number,
                    'email' => $a->email,
                    'role' => $a->role,
                    'username' => $a->user_login['username']
                );
            }
            $response = [
                'user' => $dataToSend,
                'message' => 'Data Loaded!'
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
    public function getUser()
    {
        $user = User::with(['user_login'])->get();
        return response()->json($user, 200);
    }
}
