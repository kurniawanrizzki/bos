<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
        $userId = $this->getUserId(Session::get('token'));
        $transactions = Transaction::select(
                         "TRANSACTION.TRANSACTION_ID",
                         "TRANSACTION.TRANSACTION_NUMBER",
                         "TRANSACTION.TRANSACTION_DATE",
                         "TRANSACTION.INVOICE_NUMBER",
                         "CLIENT.CLIENT_NAME as CUSTOMER_NAME",
                         "TRANSACTION.IS_CANCELED",
                         "TRANSACTION.IS_TRANSFERED",
                         "TRANSACTION.IS_DELIVERED"
                         )
                        ->join('CLIENT','CLIENT.CLIENT_ID','=','TRANSACTION.CLIENT_ID')
                        ->orderBy('TRANSACTION.TRANSACTION_ID','DESC')
                        ->where('TRANSACTION.USER_ID','=',$userId)
                        ->limit(Config::get('app.limited_fetch_data'));

        return $transactions->get();
    }

    protected function getLastItem () {
        $userId = $this->getUserId(Session::get('token'));
        $items = Item::orderBy('ITEM_ID','DESC')
                ->where('USER_ID','=',$userId)
                ->limit(Config::get('app.limited_fetch_data'));
        return $items->get();
    }

}
