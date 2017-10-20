<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public $unauthorizedStatus = 403;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin|user']);
    }

    public function car(Request $request)
    {
        DB::beginTransaction();
        try {
            $branch = Auth::user()->branch_id;
            $customer = $request->input('customer');
            $customer['branch_id'] = $branch;
            $customer_result = Customer::create($customer);
            if($customer_result){
                $car = $request->input('car');
                $car['branch_id'] = $branch;
                $car['customer_id'] = $customer->id;
                $car_result = Car::create($car);
                if($car_result){
                    DB::commit();
                    return Response::json([
                        'customer'=>$customer_result,
                        'car'=>$car_result
                    ], $this->successStatus);
                }
                else{
                    DB::rollback();
                }
            }
            else{
                DB::rollback();
            }

        } catch (Exception $e) {
            DB::rollback();
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
