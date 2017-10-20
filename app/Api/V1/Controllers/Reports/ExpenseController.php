<?php

namespace App\Api\V1\Controllers\Reports;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Ledger;
use Response;
use Validator;

class ExpenseController extends Controller
{
    use Helpers;


    public $successStatus = 200;
    public $errorStatus = 500;
    
    public function __construct()
    {
        $this->middleware(['auth:api','role:super-admin|admin|user']);
    }

    public function list(Request $request)
    { 
        try {
            $branch = Auth::user()->branch_id;
            $from =  $request->input('from', date('Y-m-d'));
            $to =  $request->input('to', date('Y-m-d'));
            $columns = ['id', 'withdraw_date', 'withdrawer', 'detail', 'amount', 'expense_id', 'payment_id'];
            $items = Ledger::searchByDate($from, $to)
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

        $cash_result = Ledger::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 1],
                ['active','=', 1]
            ])
            ->sum('amount');
        $cash += $cash_result;

        $transfer_result = Ledger::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 2],
                ['active','=', 1]
            ])
            ->sum('amount');
        $transfer += $transfer_result;

        $cheque_result = Ledger::searchByDate($from, $to)
            ->where([
                ['branch_id','=', $branch],
                ['payment_id','=', 3],
                ['active','=', 1]
            ])
            ->sum('amount');
        $cheque += $cheque_result;


        $credit_result = Ledger::searchByDate($from, $to)
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
