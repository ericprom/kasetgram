<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\User;
use Response;
use Validator;

class SystemUserController extends Controller
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
            $companies = User::SearchByKeyword($keyword)
                ->select($columns)
                ->with(['company','role'])
                ->paginate(10);

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
        $credentials = $request->only(['name', 'password']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $user = User::create($request->all());
            $roleId = $request->input('role_id');  
            $user->roles()->sync($roleId);
            return Response::json($user);
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
            $user = User::find($id);
            $user->update($request->all());
            $roleId = $request->input('role_id');  
            $user->roles()->sync($roleId);
            return Response::json($user);
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
