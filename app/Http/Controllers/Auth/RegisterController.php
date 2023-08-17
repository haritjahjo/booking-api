<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            //'role_id' => ['required', Rule::in(2, 3)],
            'role_id' => ['required', Rule::in(Role::ROLE_OWNER, Role::ROLE_USER)],
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        //$user->assignRole($request->role_id);
 
        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            return response([
                'message' => 'Email or password is incorrect',
            ], 422);
        }

        /** @var \App\Models\User $user */

        $user = Auth::user();
        
        // if(!$user->is_admin){
        //     Auth::logout();

        //     return response([
        //         'message' => 'You don\'t have permission to authenticate as admin'
        //     ], 403);
        // }

        // if (!$user->email_verified_at) {
        //     Auth::logout();
        //     return response([
        //         'message' => 'Your email address is not verified'
        //     ], 403);
        // }

        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ]);

        // $token  = $user->createToken('main')->plainTextToken;

        // return response([
        //     'user' => new UserResource($user) ,
        //     'token' => $token
        // ]);
    }

    public function logout()
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([ '', 204]);

    }
}
