<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Company;
use App\Models\User;
use App\Models\Menu;
use Response;
use Validator;

class AuthController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 401;

    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
            ], $this->errorStatus);
        }

        try {
            if (!Auth::attempt($credentials)) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Unauthorized',
                    'text' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
                ], $this->unauthorizedStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ],  $this->errorStatus);
        }

        $currentUser = Auth::user();
        if($currentUser && !$currentUser['active']){
            return Response::json([
                'type' => 'warning',
                'title' => 'Inactivated',
                'text' => 'ผู้ใช้ถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ'
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

    public function getprofile()
    {
        try {
            $user = Auth::user();
            return Response::json([
                'user' => $user
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ],  $this->errorStatus);
        }
    }

    public function updateprofile(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถอัพเดทข้อมูลได้'
                ],  $this->errorStatus);
            }
            else{
                $user = Auth::user();
                $user->update($request->all());
                return Response::json([
                    'user' => $user,
                    'type' => 'success',
                    'title' => 'Updated!',
                    'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
                ], $this->successStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function getcompany()
    {
        try {
            $branch = Auth::user()->branch_id;
            $company = Company::find($branch);
            return Response::json([
                'company' => $company
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ],  $this->errorStatus);
        }
    }

    public function updatecompany(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถอัพเดทข้อมูลได้'
                ],  $this->errorStatus);
            }
            else{
                $company = Company::find($request->id);
                $company->update($request->all());
                return Response::json([
                    'user' => $company,
                    'type' => 'success',
                    'title' => 'Updated!',
                    'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
                ], $this->successStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

}