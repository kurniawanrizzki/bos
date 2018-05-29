<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Transaction;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Order;

class TransactionController extends Controller
{
    public function index () {
      return view('pages.menu.transactions.index');
    }

    public function view ($transactionId) {
      $token = Session::get('token');
      $transactionById  = $this->getList($transactionId, $this->getUserId($token))->get();
      $orderByTransactionId = $this->getOrdersDetail($transactionId);
      return view('pages.menu.transactions.view',[
        'transaction'=>$transactionById,
        'orders'=>$orderByTransactionId
      ]);
    }

    public function delete ($transactionId) {
      $find = Transaction::where('TRANSACTION_ID','=',$transactionId);
      if ($find->count() > 0) {
        $find->delete();
        Order::where('TRANSACTION_ID','=',$transactionId)->delete();
        return redirect()->route('transaction.index');
      }
      return abort(404);
    }

    public function update (Request $request) {
      $status = "";
      $find = Transaction::where('TRANSACTION_ID','=',$request->id);

      if ($find->count() > 0) {

        $status = $request->updated;
        if ($status == Lang::get('string.delivered_status')) {
            $find->update(['IS_DELIVERED'=>1]);
        } else if ($status == Lang::get('string.canceled_status')) {
            $find->update(['IS_CANCELED'=>1]);
        } else if ($status == Lang::get('string.transfered_status')) {
            $find->update(['IS_TRANSFERED'=>1]);
        }

      }

      return response()->json(
        [
            "updated"=> $status
        ]
      );

    }

    public function print ($transactionId) {
      $token = Session::get('token');
      $transactionById  = $this->getList($transactionId, $this->getUserId($token))->get();
      $orderByTransactionId = $this->getOrdersDetail($transactionId);

      if (sizeof($transactionById) > 0) {

          $pdf = PDF::loadView('layouts.invoice', [
            'transaction'=>$transactionById,
            'orders'=>$orderByTransactionId
          ]);

          $customPaper = array(0,0,567.00,283.80);
          $pdf->setPaper($customPaper, 'portrait')->setWarnings(false);
          return $pdf->download();

      }

    }

    protected function getList ($transactionId,$userId) {
      $transactions = Transaction::select(
                       "TRANSACTION.TRANSACTION_ID",
                       "TRANSACTION.TRANSACTION_NUMBER",
                       "TRANSACTION.TRANSACTION_DATE",
                       "TRANSACTION.INVOICE_NUMBER",
                       "TRANSACTION.SHIPPING_TYPE",
                       "TRANSACTION.SHIPPING_TOTAL",
                       "CLIENT.CLIENT_NAME as CUSTOMER_NAME",
                       "CLIENT.CLIENT_ADDRESS as ADDRESS",
                       "CLIENT.CLIENT_DISTRICTS as DISTRICT",
                       "CLIENT.CLIENT_PROVINCE as PROVINCE",
                       "CLIENT.CLIENT_HP as HP",
                       "TRANSACTION.IS_DELIVERED",
                       "TRANSACTION.IS_TRANSFERED",
                       "TRANSACTION.IS_CANCELED",
                       \Illuminate\Support\Facades\DB::raw(
                          "(CASE ".
                            "WHEN ((TRANSACTION.IS_TRANSFERED = 1) && (TRANSACTION.IS_DELIVERED = 1) && (TRANSACTION.IS_CANCELED = 0)) THEN 4 ". //already delivered
                            "WHEN ((TRANSACTION.IS_TRANSFERED = 1) && (TRANSACTION.IS_DELIVERED = 0) && (TRANSACTION.IS_CANCELED = 0)) THEN 3 ". //already transfered
                            "WHEN ((TRANSACTION.IS_TRANSFERED = 1) && (TRANSACTION.IS_DELIVERED = 0) && (TRANSACTION.IS_CANCELED = 1)) THEN 2 ". //canceled but already transfered
                            "WHEN ((TRANSACTION.IS_TRANSFERED = 0) && (TRANSACTION.IS_DELIVERED = 0) && (TRANSACTION.IS_CANCELED = 1)) THEN 1 ". //canceled
                            "WHEN ((TRANSACTION.IS_TRANSFERED = 0) && (TRANSACTION.IS_DELIVERED = 0) && (TRANSACTION.IS_CANCELED = 0)) THEN 0 ". //waiting
                            "ELSE -1 ".//unknown
                          "END) AS STATUS"
                       )
                      )
                      ->join('CLIENT','CLIENT.CLIENT_ID','=','TRANSACTION.CLIENT_ID')
                      ->where('TRANSACTION.USER_ID','=',$userId);

        if (null != $transactionId) {
          $transactions->addSelect(\Illuminate\Support\Facades\DB::raw("(SELECT SUM(TOTAL_PRICE) FROM ORDERS WHERE TRANSACTION_ID = ".$transactionId.") AS TOTAL"))
                       ->where('TRANSACTION.TRANSACTION_ID','=',$transactionId);
        }

        return $transactions;
    }

    public function getAllList (Request $request) {

      $this->validate($request, Config::get('app.request_rule'));
      $userId = $this->getUserId($request->token);

      $transactions = $this->getList(null,$userId);
      $search = Input::get('search.value');
      if (!empty($search)) {
          $filtered = "%".$search."%";
          $transactions = $transactions->where("TRANSACTION.TRANSACTION_NUMBER","LIKE",$filtered)
                          ->orWhere("TRANSACTION.INVOICE_NUMBER","LIKE",$filtered)
                          ->orWhere("CLIENT.CLIENT_NAME","LIKE",$filtered);
      }
      return \DataTables::of($transactions)
              ->addColumn('ACTION', function ($transactions){
                return '<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="'.route("transaction.view",[$transactions->TRANSACTION_ID]).'"><i class="material-icons">search</i></a>
                <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="'.route("transaction.print",[$transactions->TRANSACTION_ID]).'"><i class="material-icons">print</i></a>
                <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="'.route("transaction.delete",[$transactions->TRANSACTION_ID]).'"><i class="material-icons">delete</i></a>';
              })
              ->addColumn('STATUS_HTML', function($transactions){
                $color = $transactions->STATUS == 4?'btn-success':
                        ($transactions->STATUS == 3?btn-primary:
                            (($transactions->STATUS == 2) || ($transactions->STATUS == 1)?'btn-danger':
                            ($transactions->STATUS == 0?'btn-info':'btn-warning')));

                $disabled = ($transactions->STATUS == 4) || ($transactions->STATUS == 2) || ($transactions->STATUS == 1)?'disabled':'';

                $transactionLabel = null;

                if ($transactions->STATUS == 4) {
                    $transactionLabel = Lang::get('string.delivered_status');
                } else if ($transactions->STATUS == 3) {
                    $transactionLabel = Lang::get('string.transfered_status');
                } else if ($transactions->STATUS == 2) {
                    $transactionLabel = Lang::get('string.paid_canceled_status');
                } else if ($transactions->STATUS == 1) {
                    $transactionLabel = Lang::get('string.canceled_status');
                } else if ($transactions->STATUS == 0) {
                    $transactionLabel = Lang::get('string.waiting_status');
                } else {
                    $transactionLabel = Lang::get('string.unknown_status');
                }

                return '<td>
                  <input type="hidden" name="transaction_id" id="transaction_id" value="'.$transactions->TRANSACTION_ID.'">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn waves-effect dropdown-toggle '.$color.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" id="bos-status" '.$disabled.' >'.$transactionLabel.'<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu bos-status-dropdown">
                        <li><a class=" waves-effect waves-block">'.Lang::get('string.delivered_status').'</a></li>
                        <li><a class=" waves-effect waves-block">'.Lang::get('string.transfered_status').'</a></li>
                        <li><a class=" waves-effect waves-block">'.Lang::get('string.canceled_status').'</a></li>
                    </ul>
                  </div>
                </td>';
              })
              ->rawColumns(["ACTION","STATUS_HTML"])
              ->make();
    }

    protected function getOrdersDetail ($transactionId) {
      $ordersDetail = Order::select('ORDERS.ORDERS_ID','ORDERS.TRANSACTION_ID','ITEM.ITEM_CODE','ITEM.ITEM_NAME','ITEM.ITEM_SIZE','ITEM.ITEM_WEIGHT','ITEM.ITEM_PRICE','ORDERS.TOTAL_ITEM','ORDERS.TOTAL_PRICE')
                      ->join('ITEM','ORDERS.ITEM_ID','=','ITEM.ITEM_ID')
                      ->where('ORDERS.TRANSACTION_ID', '=' ,$transactionId);
      return $ordersDetail->get();
    }

}
