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

class RoleController extends Controller {
	use Helpers;

    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin']);
    }

    public function index() {

        try {
            $columns = ['id', 'name', 'guard_name'];
            $roles = Role::select($columns)->paginate(10);

            return Response::json([
                'status' => true,
                'data' => $roles,
                'pagination' => [
                    'total' => $roles->total(),
                    'per_page' => $roles->perPage(),
                    'current_page' => $roles->currentPage(),
                    'last_page' => $roles->lastPage(),
                    'from' => $roles->firstItem(),
                    'to' => $roles->lastItem()
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

}