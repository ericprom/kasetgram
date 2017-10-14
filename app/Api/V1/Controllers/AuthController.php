<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;

class AuthController extends Controller
{

    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['access_token'] =  $user->createToken('adminApp')->accessToken;
            $success['current_user'] =  $user;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $success['access_token'] =  null;
        $success['current_user'] =  null;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        //$roles = $input['roles'];
        //if (isset($roles)) {
        // foreach ($roles as $role) {
        //     $role_r = Role::where('id', '=', $role)->firstOrFail();            
        //     $user->assignRole($role_r); //Assigning role to user
        // }
        //}

        $success['token'] =  $user->createToken('adminApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        
        //$roles = Role::get();            
        //$user->roles()->sync($roles);

        //if($user->hasRole(['admin'])){
            $success['current_user'] =  $user;
            return response()->json(['success' => $success], $this->successStatus);
        // }
        // else{

        //     return response()->json(['success' => $user], $this->successStatus);
        // }
    }
}