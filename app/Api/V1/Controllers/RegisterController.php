<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Models\Customer;
use App\Models\Car;
use Response;
use Validator;
use DB;

class RegisterController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin|user']);
    }

    public function car(Request $request)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'customer.firstname' => 'required',
                'customer.lastname' => 'required',
                'customer.tax_id' => 'required',

                'car.type_id' => 'required',
                'car.make_id' => 'required',
                'car.license' => 'required',
                'car.province' => 'required',
            ]);
            
            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                ], $this->errorStatus);
            }
            else{
                $branch = Auth::user()->branch_id;
                $customer = $request->input('customer');
                $customer['branch_id'] = $branch;
                $customer_result = Customer::create($customer);
                if($customer_result){
                    $car = $request->input('car');
                    $car['branch_id'] = $branch;
                    $car['customer_id'] = $customer_result->id;
                    $car_result = Car::create($car);
                    if($car_result){
                        DB::commit();
                        return Response::json([
                            'type' => 'success',
                            'title' => 'Save!',
                            'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
                        ], $this->successStatus);
                    }
                    else{
                        DB::rollback();
                        return Response::json([
                            'type' => 'warning',
                            'title' => 'Warning',
                            'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                        ], $this->errorStatus);
                    }
                }
                else{
                    DB::rollback();
                    return Response::json([
                        'type' => 'warning',
                        'title' => 'Warning',
                        'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                    ], $this->errorStatus);
                }
            }

        } catch (Exception $e) {
            DB::rollback();
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
