<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;

class AuthController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 403;

    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }

        try {
            if (!Auth::attempt($credentials)) {
                return Response::json([
                    'code' => 'warning',
                    'title' => 'Unauthorized',
                    'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
                ], $this->unauthorizedStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ],  $this->errorStatus);
        }

        $currentUser = Auth::user();
        if($currentUser && !$currentUser['active']){
            return Response::json([
                'code' => 'warning',
                'title' => 'Inactivated',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->unauthorizedStatus);
        }
        else{
            return Response::json([
                'token' => $currentUser->createToken('adminApp')->accessToken
            ], $this->successStatus);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return Response::json(['success' => true], $this->successStatus);
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
                        'title' => 'จัดการพนักงาน',
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
                    [
                        'name' => 'settings.insurance',
                        'title' => 'บริษัทประกัน',
                        'icon' => 'fa fa-handshake-o',
                    ],
                ]
            ]
        ];
        if(Auth::user()->hasRole('super-admin')){
            $menus[] = [ 
                'name' => '',
                'title' => 'จัดการระบบ',
                'icon' => 'fa fa-tv',
                'child' => [
                    [
                        'name' => 'systems.company',
                        'title' => 'จัดการบริษัท',
                        'icon' => 'fa fa-building-o',
                    ],
                    [
                        'name' => 'systems.role',
                        'title' => 'จัดการตำแหน่ง',
                        'icon' => 'fa fa-key',
                    ],
                    [
                        'name' => 'systems.permission',
                        'title' => 'จัดการสิทธิ์',
                        'icon' => 'fa fa-id-badge',
                    ],
                    [
                        'name' => 'systems.user',
                        'title' => 'เพิ่มผู้ใช้งานในระบบ',
                        'icon' => 'fa fa-users',
                    ],
                ]
            ];
        }
        return Response::json([
            'menus' => $menus
        ], $this->successStatus);
    }

    public function details()
    {
        try {
            $user = Auth::user();
            return Response::json([
                'user' => $user
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ],  $this->errorStatus);
        }
    }
}