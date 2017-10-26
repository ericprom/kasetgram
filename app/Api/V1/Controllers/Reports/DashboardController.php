<?php

namespace App\Api\V1\Controllers\Reports;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Income;
use App\Models\Expense;
use Response;
use Validator;

class DashboardController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin']);
    }

    public function income(Request $request)
    { 
        try {
            $branch = Auth::user()->branch_id;
            $columns = ['id', 'receive_date', 'receiver', 'detail', 'amount', 'farm_id', 'payment_id'];
            $items = Income::select($columns)
                ->with(['farm','payment'])
                ->where('branch_id','=',$branch)
                ->latest()
                ->paginate(10);

            return Response::json([
                'data' => $items
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function expense(Request $request)
    { 
        try {
            $branch = Auth::user()->branch_id;
            $columns = ['id', 'withdraw_date', 'withdrawer', 'detail', 'amount', 'farm_id', 'payment_id'];
            $items = Expense::select($columns)
                ->with(['farm','payment'])
                ->where('branch_id','=',$branch)
                ->latest()
                ->paginate(10);

            return Response::json([
                'data' => $items
            ]);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถโหลดข้อมูลได้'
            ], $this->errorStatus);
        }
    }

    public function summary(Request $request)
    {
        $branch = Auth::user()->branch_id;
        $from =  $request->input('from', date('Y-m-d'));
        $to =  $request->input('to', date('Y-m-d'));
        $cash = 0;
        $transfer = 0;
        $cheque = 0;
        $credit = 0;

        $cash_result = Income::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 1],
                ['active','=', 1]
            ])
            ->sum('amount');
        $cash += $cash_result;

        $transfer_result = Income::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 2],
                ['active','=', 1]
            ])
            ->sum('amount');
        $transfer += $transfer_result;

        $cheque_result = Income::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 3],
                ['active','=', 1]
            ])
            ->sum('amount');
        $cheque += $cheque_result;


        $credit_result = Income::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 4],
                ['active','=', 1]
            ])
            ->sum('amount');
        $credit += $credit_result;
        
        $items = [
            'cash'=>$cash,
            'transfer'=>$transfer,
            'cheque'=>$cheque,
            'credit'=>$credit,
        ];
        
        return Response::json($items);
    }
}
