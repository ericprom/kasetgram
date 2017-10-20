<?php

namespace App\Api\V1\Controllers\Systems;

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
        $this->middleware(['auth:api','role:super-admin']);
    }

    public function index(Request $request)
    { 
        try {
            $keyword =  $request->input('keyword', '');
            $columns = ['id', 'name', 'address', 'phone'];
            $items = Company::SearchByKeyword($keyword)
                ->select($columns)
                ->latest()
                ->paginate(10);

            return Response::json([
                'status' => true,
                'data' => $items,
                'pagination' => [
                    'total' => $items->total(),
                    'per_page' => $items->perPage(),
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'from' => $items->firstItem(),
                    'to' => $items->lastItem()
                ]
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            Company::create($request->all());

            return Response::json([
                'type' => 'success',
                'title' => 'Save!',
                'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
            ], $this->successStatus);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
        else{
            Company::find($id)->update($request->all());
            return Response::json([
                'type' => 'success',
                'title' => 'Save!',
                'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
            ], $this->successStatus);
        }
    }

    public function destroy($id)
    {
    
        try {
            Company::find($id)->delete();
            return Response::json([
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'ระบบได้ทำการลบข้อมูลเรียบร้อยแล้ว'
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถลบข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
