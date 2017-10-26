<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Payment;
use App\Models\Farm;
use Response;
use Validator;

class DatalistController extends Controller
{

    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 403;

    public function menus()
    {
        return Response::json([
            'menus' => self::buildMenus(Menu::tree(),Auth::user()->roles->first()->name)
        ], $this->successStatus);
    }

    public static function buildMenus($menuItems, $userrole)
    {
        $menus = array();
        foreach ($menuItems as $k => $v) {
            if (in_array($userrole, explode(',', $v['role']))) {
                $menus[$k] = $v;
                foreach ($menus[$k]['children'] as $k2 => $v2) {
                    if (in_array($userrole, explode(',', $v2['role']))) {
                        $menus[$k]['children'][$k2] = $v2;
                    }
                    else{
                        unset($menus[$k]['children'][$k2]);
                    }
                }
            }
        }
        return array_values($menus);
    }

    public function companies() {
        try {
            $columns = ['id', 'name'];
            $criteria = [];
            $companies = Company::select($columns)->where($criteria)->get();
           foreach($companies as &$val){
                $val['label'] = $val['name'];
                unset($val['name']);
            }
            return Response::json([
                'companies' => $companies
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }


    public function roles() {
        try {
            $columns = ['id', 'name'];
            $criteria = [];
            if(!Auth::user()->hasRole('super-admin')){
                $criteria[] =['id','<>', 1];
            }
            $roles = Role::select($columns)->where($criteria)->get();

           foreach($roles as &$val){
                $val['label'] = $val['name'];
                unset($val['name']);
            }
            
            return Response::json([
                'roles' => $roles
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function payments() {
        try {
            $columns = ['id', 'name'];
            $items = Payment::select($columns)->get();
           foreach($items as &$val){
                $val['label'] = $val['name'];
                unset($val['name']);
            }
            return Response::json([
                'payments' => $items
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function farms() {
        try {
            $columns = ['id', 'name'];
            $branch = Auth::user()->branch_id;
            $items = Farm::select($columns)->where('branch_id','=',$branch)->get();
           foreach($items as &$val){
                $val['label'] = $val['name'];
                unset($val['name']);
            }
            return Response::json([
                'farms' => $items
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

}