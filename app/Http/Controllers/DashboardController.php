<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    public function index () {
      $transactions = $this->getLastTranscation();
      $items = $this->getLastItem();
      return view('pages.menu.index',[
        'transactions' => $transactions,
        'items' => $items
      ]);
    }

    protected function getLastTranscation () {
        $transactions = Transaction::select(
                         "TRANSACTION.TRANSACTION_ID",
                         "TRANSACTION.TRANSACTION_NUMBER",
                         "TRANSACTION.TRANSACTION_DATE",
                         "TRANSACTION.INVOICE_NUMBER",
                         "CLIENT.CLIENT_NAME as CUSTOMER_NAME",
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
                        ->orderBy('TRANSACTION.TRANSACTION_ID','DESC')
                        ->where('TRANSACTION.USER_ID','=',$this->getUserId())
                        ->limit(Config::get('app.limited_fetch_data'));

        return $transactions->get();
    }

    protected function getLastItem () {
        $items = Item::orderBy('ITEM_ID','DESC')
                ->where('USER_ID','=',$this->getUserId())
                ->limit(Config::get('app.limited_fetch_data'));
        return $items->get();
    }

}
