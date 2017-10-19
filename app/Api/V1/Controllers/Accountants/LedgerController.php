<?php

namespace App\Api\V1\Controllers\Accountants;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Ledger;
use Response;
use Validator;

class LedgerController extends Controller
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
            $columns = ['id', 'withdraw_date', 'withdrawer', 'detail', 'amount', 'expense_id', 'payment_id'];
            $items = Ledger::SearchByKeyword($keyword)
                ->select($columns)
                ->with(['expense','payment'])
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
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }
    public function store(Request $request)
    {
        try {
            $credentials = $request->only(['name']);

            $validator = Validator::make($credentials, [
                'name' => 'required'
            ]);
            
            if ($validator->fails()) {
                return Response::json([
                    'code' => 'warning',
                    'title' => 'Warning',
                    'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
                ], $this->errorStatus);
            }
            else{
                $item = Ledger::create($request->all());
                return Response::json($item);
            }
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            // $credentials = $request->only(['name']);

            // $validator = Validator::make($credentials, [
            //     'name' => 'required'
            // ]);

            // if ($validator->fails()) {
            //     return Response::json([
            //         'code' => 'warning',
            //         'title' => 'Warning',
            //         'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            //     ], $this->errorStatus);
            // }
            // else{
                $item = Ledger::find($id);
                $item->update($request->all());
                return Response::json($item);
            // }
        } catch (Exception $e) {
            return Response::json([
                'code' => 'warning',
                'title' => 'Warning',
                'message' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function destroy($id)
    {
    
        try {
            Ledger::find($id)->delete();
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