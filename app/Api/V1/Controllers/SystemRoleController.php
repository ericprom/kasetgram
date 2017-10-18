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

class SystemRoleController extends Controller {
	use Helpers;

    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin']);
    }

    public function index() {

        try {
            $columns = ['id', 'name', 'guard_name'];
            $items = Role::select($columns)->paginate(10);

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
        $credentials = $request->only(['name','guard_name']);

        $validator = Validator::make($credentials, [
            'name' => 'required',
            'guard_name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return Response::json(['errors'=>$validator->errors()]);
        }
        else{
            $item = Role::create($request->all());

            return Response::json($item);
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
            $item = Role::find($id)->update($request->all());

            return Response::json($item);
        }
    }

    public function destroy($id)
    {
    
        try {
            Role::find($id)->delete();
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