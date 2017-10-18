<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Response;
use Validator;

class SystemPermissionController extends Controller {
	use Helpers;

    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin']);
    }

    public function index() {
        try {
            $columns = ['id', 'name', 'guard_name'];
            $permissions = Permission::select($columns)->paginate(10);

            return Response::json([
                'status' => true,
                'data' => $permissions,
                'pagination' => [
                    'total' => $permissions->total(),
                    'per_page' => $permissions->perPage(),
                    'current_page' => $permissions->currentPage(),
                    'last_page' => $permissions->lastPage(),
                    'from' => $permissions->firstItem(),
                    'to' => $permissions->lastItem()
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
        $credentials = $request->only(['name','guard_name']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'guard_name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $create = Permission::create($request->all());

            return Response::json($create);
        }
    }

    public function update(Request $request, $id)
    {
        $credentials = $request->only(['name','guard_name']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $edit = Permission::find($id)->update($request->all());

            return Response::json($edit);
        }
    }
    
    public function destroy($id)
    {
    
        try {
            Permission::find($id)->delete();
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