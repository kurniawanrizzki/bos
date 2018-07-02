<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\User;
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

    public function profile () {
        $user = $this->getUserInfo();
        return view('pages.menu.profiles.index',['user'=>$user]);
    }

    public function edit () {
        $user = $this->getUserInfo();
        return view('pages.menu.profiles.form',['user'=>$user]);
    }

    public function update(Request $request) {
        $userId = $this->getUserId(Session::get('token'));
        $user = User::find($userId);
        if ($user->count() > 0) {

            $rules = Config::get('app.profile_rule');
            // $rules['profile_email'] .= '|unique:USER,USER_EMAIL,'.$userId.',USER_ID';
            $this->validate ($request,$rules, Lang::get('validation.item_validation_messages'));

            $user->USER_ADDRESS = $request->profile_address;
            $user->USER_EMAIL = $request->profile_email;
            $user->USER_HP = $request->profile_hp;
            $user->USER_OPEN_TIME = $request->profile_open_po;
            $user->USER_CLOSE_TIME = $request->profile_close_po;
            $user->save();

            return redirect()->route('profile.index');
        }
        return abort(404);
    }

    protected function getUserInfo () {
        $userId = $this->getUserId(Session::get('token'));
        $user = User::select(
            "USER_NAME",
            "USER_EMAIL",
            "USER_HP",
            "USER_ADDRESS",
            "USER_OPEN_TIME",
            "USER_CLOSE_TIME"
            )
            ->where('USER_ID','=',$userId)
            ->get();
        return $user;
    }

    protected function getLastItem () {
        $userId = $this->getUserId(Session::get('token'));
        $items = Item::orderBy('ITEM_ID','DESC')
                ->where('USER_ID','=',$userId)
                ->limit(Config::get('app.limited_fetch_data'));
        return $items->get();
    }

}
