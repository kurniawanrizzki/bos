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

      $userId = $this->getUserId($request->token);
      $find = Transaction::where('TRANSACTION_ID','=',$request->id)->where('USER_ID','=',$userId)->get();

      if (count($find) > 0) {
        if ($request->type == 0) {
          $find[0]->IS_CANCELED = $find[0]->IS_CANCELED == 0?1:0;
        } else if ($request->type == 1) {
          $find[0]->IS_TRANSFERED = $find[0]->IS_TRANSFERED == 0?1:0;
        } else if ($request->type == 2) {
          if ($find[0]->IS_DELIVERED < 1) {
            if ($request->invoice != '') {
              $find[0]->INVOICE_NUMBER = $request->invoice;
            } else {
              return response()->json(
                [
                    "updated"=> false,
                    "cause" => "Please to fill the invoice number before confirm it."
                ]
              );
            }
          }
          $find[0]->IS_DELIVERED = $find[0]->IS_DELIVERED == 0?1:0;
        }

        $find[0]->save();
        return response()->json([
          "updated" => true
        ]);
      }

      return response()->json(
        [
            "updated"=> false,
            "cause" => "There is something wrong."
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
                       'TRANSACTION.SHIPPING_TOTAL_WEIGHT',
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

      if ((null != $request->IS_CANCELED) && (null != $request->IS_TRANSFERED) && (null != $request->IS_DELIVERED)) {
        dd($request->IS_CANCELED);
        $transactions = $transactions->where("TRANSACTION.IS_CANCELED","=",$request->IS_CANCELED)
                        ->where("TRANSACTION.IS_TRANSFERED","=",$request->IS_TRANSFERED)
                        ->where("TRANSACTION.IS_DELIVERED","=",$request->IS_DELIVERED);
      }

      return \DataTables::of($transactions)
              ->editColumn('IS_CANCELED', function($transactions) {
                return $this->getStatusAttr(
                  $transactions->TRANSACTION_ID,
                  $transactions->IS_CANCELED,
                  $transactions->TRANSACTION_NUMBER,
                  0
                );
              })
              ->editColumn('IS_TRANSFERED', function($transactions){
                return $this->getStatusAttr(
                  $transactions->TRANSACTION_ID,
                  $transactions->IS_TRANSFERED,
                  $transactions->TRANSACTION_NUMBER,
                  1
                );
              })
              ->editColumn('IS_DELIVERED', function($transactions){
                return $this->getStatusAttr(
                  $transactions->TRANSACTION_ID,
                  $transactions->IS_DELIVERED,
                  $transactions->TRANSACTION_NUMBER,
                  2
                );
              })
              ->rawColumns(["IS_CANCELED","IS_TRANSFERED","IS_DELIVERED"])
              ->make();
    }

    protected function getStatusAttr ($id, $value, $desc, $type) {
      $btnColor = $value == 0?'btn-danger':'btn-info';
      $btnIcon = $value == 0?'close':'check';
      return '
        <a data-target="#status_update_confirmation_modal" data-toggle="modal" data-transaction-id="'.$id.'" data-transaction-value="'.$value.'" data-transaction-number="'.$desc.'" data-transaction-attribute="'.$type.'" class="btn '.$btnColor.' waves-effect waves-float">
          <i class="material-icons">'.$btnIcon.'</i>
        </a>';
    }

    protected function getOrdersDetail ($transactionId) {
      $ordersDetail = Order::select('ORDERS.ORDERS_ID','ORDERS.TRANSACTION_ID','ITEM.ITEM_CODE','ITEM.ITEM_NAME','ITEM.ITEM_SIZE','ITEM.ITEM_WEIGHT','ITEM.ITEM_PRICE','ORDERS.TOTAL_ITEM','ORDERS.TOTAL_PRICE')
                      ->join('ITEM','ORDERS.ITEM_ID','=','ITEM.ITEM_ID')
                      ->where('ORDERS.TRANSACTION_ID', '=' ,$transactionId);
      return $ordersDetail->get();
    }

}
