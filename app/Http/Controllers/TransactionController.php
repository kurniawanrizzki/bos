<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Lang;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Order;

class TransactionController extends Controller
{
    public function index () {
      $transactions = $this->getAllList();
      return view('pages.menu.transactions.index',[
        'transactions'=>$transactions
      ]);
    }

    public function view ($transactionId) {
      $transactionById  = $this->getList($transactionId);
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
      $transactionById  = $this->getList($transactionId);
      $orderByTransactionId = $this->getOrdersDetail($transactionId);

      if (sizeof($transactionById) > 0) {

          $pdf = PDF::loadView('layouts.invoice', [
            'transaction'=>$transactionById,
            'orders'=>$orderByTransactionId
          ]);

          $pdf->setPaper('a4', 'landscape')->setWarnings(false);
          return $pdf->download();

      }

    }

    protected function getList ($transactionId) {
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
                      ->where('TRANSACTION.USER_ID','=',$this->getUserId());

        if (null != $transactionId) {
          $transactions->addSelect(\Illuminate\Support\Facades\DB::raw("(SELECT SUM(TOTAL_PRICE) FROM ORDERS WHERE TRANSACTION_ID = ".$transactionId.") AS TOTAL"))
                       ->where('TRANSACTION.TRANSACTION_ID','=',$transactionId);
        }

        return $transactions->get();
    }

    protected function getAllList () {
      return $this->getList(null);
    }

    protected function getOrdersDetail ($transactionId) {
      $ordersDetail = Order::select('ORDERS.ORDERS_ID','ORDERS.TRANSACTION_ID','ITEM.ITEM_CODE','ITEM.ITEM_NAME','ITEM.ITEM_SIZE','ITEM.ITEM_WEIGHT','ITEM.ITEM_PRICE','ORDERS.TOTAL_ITEM','ORDERS.TOTAL_PRICE')
                      ->join('ITEM','ITEM.ITEM_ID','=','ITEM.ITEM_ID')
                      ->groupBy('ORDERS.ORDERS_ID')
                      ->havingRaw('ORDERS.TRANSACTION_ID = '.$transactionId);
      return $ordersDetail->get();
    }

}
