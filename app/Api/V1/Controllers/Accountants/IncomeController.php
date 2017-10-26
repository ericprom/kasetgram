<?php

namespace App\Api\V1\Controllers\Accountants;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Income;
use Response;
use Validator;

class IncomeController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    public $unauthorizedStatus = 403;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin|user']);
    }

    public function index(Request $request)
    { 
        try {
            $branch = Auth::user()->branch_id;
            $keyword =  $request->input('keyword', '');
            $columns = ['id', 'receive_date', 'receiver', 'detail', 'amount', 'farm_id', 'payment_id'];
            $items = Income::searchByKeyword($keyword)
                ->select($columns)
                ->with(['farm','payment'])
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
                'amount' => 'required',
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
                Income::create($item);
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
                'amount' => 'required'
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'type' => 'warning',
                    'title' => 'Warning',
                    'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                ], $this->errorStatus);
            }
            else{
                $item = Income::find($id);
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
            Income::find($id)->delete();
            return Response::json([
                'type' => 'success',
                'title' => 'Deleted!',
                'text' => 'ระบบได้ทำการลบข้อมูลเรียบร้อยแล้ว'
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถลบข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
