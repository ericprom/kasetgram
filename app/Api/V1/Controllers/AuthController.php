<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        
        $success['token'] =  $user->createToken('adminApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function menus()
    {
        $menus =  [
            [ 
                'name' => 'dashboard',
                'title' => 'ภาพรวม',
                'icon' => 'fa fa-star-o'
            ],
            [ 
                'name' => 'car-register',
                'title' => 'นำเข้าข้อมูลจดทะเบียน',
                'icon' => 'fa fa-edit'
            ],
            [ 
                'name' => 'customers',
                'title' => 'สมุดรายชื่อลูกค้า',
                'icon' => 'fa fa-book'
            ],
            [ 
                'name' => '',
                'title' => 'ตั้งค่า',
                'icon' => 'fa fa-cogs',
                'child' => [
                    [
                        'name' => 'settings.company',
                        'title' => 'แก้ไขข้อมูลบริษัท',
                        'icon' => 'fa fa-building',
                    ],
                    [
                        'name' => 'settings.employee',
                        'title' => 'เพิ่มผู้ใช้งานในระบบ',
                        'icon' => 'fa fa-user-circle-o',
                    ],
                    [
                        'name' => 'settings.car',
                        'title' => 'จัดการข้อมูลรถ',
                        'icon' => 'fa fa-car',
                    ],
                    [
                        'name' => 'settings.payment',
                        'title' => 'บัญชีธนาคาร',
                        'icon' => 'fa fa-money',
                    ],
                    [
                        'name' => 'settings.service',
                        'title' => 'ประเภทบริการ',
                        'icon' => 'fa fa-sitemap',
                    ],
                ]
            ]
        ];
        return response()->json(['menus' => $menus], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        
        $success['current_user'] =  $user;
        return response()->json(['success' => $success], $this->successStatus);
    }
}