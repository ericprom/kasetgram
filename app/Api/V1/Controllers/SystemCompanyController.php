<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Company;
use Response;
use Validator;

class SystemCompanyController extends Controller
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
            $item = Company::create($request->all());

            return Response::json($item);
        }
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->only(['name', 'branch', 'address', 'phone', 'fax', 'branch_of', 'tax_id']);

        $validator = Validator::make($credentials, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $item = Company::find($id)->update($request->all());

            return Response::json($item);
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
