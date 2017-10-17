<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Company;
use Response;
use Validator;

class CompanyController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 403;
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    { 
        try {
            $columns = ['id', 'name', 'address'];
            $companies = Company::select($columns)->latest()->paginate(10);

            return Response::json([
                'status' => true,
                'data' => $companies,
                'pagination' => [
                    'total' => $companies->total(),
                    'per_page' => $companies->perPage(),
                    'current_page' => $companies->currentPage(),
                    'last_page' => $companies->lastPage(),
                    'from' => $companies->firstItem(),
                    'to' => $companies->lastItem()
                ]
            ]);
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }
    public function store(Request $request)
    {
        $credentials = $request->only(['name']);

        $validator = Validator::make($credentials, [
            'name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $create = Company::create($request->all());

            return Response::json($create);
        }
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->only(['name']);

        $validator = Validator::make($credentials, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $edit = Company::find($id)->update($request->all());

            return Response::json($edit);
        }


    }
    public function destroy($id)
    {
    
        try {
            Company::find($id)->delete();
            return Response::json([
                'code' => 'success',
                'title' => 'Deleted!',
                'message' => 'ระบบได้ทำการลบข้อมูลเรียบร้อยแล้ว'
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถลบข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
