<?php

namespace App\Api\V1\Controllers\Settings;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Bank;
use Response;
use Validator;

class BankController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 403;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin']);
    }

    public function index(Request $request)
    { 
        try {
            $branch = Auth::user()->branch_id;
            $keyword =  $request->input('keyword', '');
            $columns = ['id', 'name', 'account_name', 'account_number'];
            $items = Bank::SearchByKeyword($keyword)
                ->select($columns)
                ->where('branch_id','=',$branch)
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
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
            ]);
            
            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                ], $this->errorStatus);
            }
            else{
                $item = $request->all();
                $item['branch_id'] = Auth::user()->branch_id;
                Bank::create($item);
                return Response::json([
                    'type' => 'success',
                    'title' => 'Save!',
                    'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
                ], $this->successStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                ], $this->errorStatus);
            }
            else{
                $item = Bank::find($id);
                $item->update($request->all());
                return Response::json([
                    'type' => 'success',
                    'title' => 'Save!',
                    'text' => 'ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว'
                ], $this->successStatus);
            }
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function destroy($id)
    {
    
        try {
            Bank::find($id)->delete();
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
