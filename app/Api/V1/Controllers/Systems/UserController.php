<?php

namespace App\Api\V1\Controllers\Systems;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User;
use Response;
use Validator;

class UserController extends Controller
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
            $columns = ['id', 'name', 'phone', 'email', 'branch_id'];
            $items = User::SearchByKeyword($keyword)
                ->select($columns)
                ->with(['company','role'])
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
        $credentials = $request->only(['name', 'password']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $item = User::create($request->all());
            $roleId = $request->input('role_id');  
            $item->roles()->sync($roleId);
            return Response::json($item);
        }
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->only(['name', 'email']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
        else{
            $item = User::find($id);
            $item->update($request->all());
            $roleId = $request->input('role_id');  
            $item->roles()->sync($roleId);
            return Response::json($item);
        }
    }

    public function destroy($id)
    {
    
        try {
            User::find($id)->delete();
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
