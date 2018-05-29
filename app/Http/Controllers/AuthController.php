<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{

    /**
     * Initiate welcome page;
     */
    public function index () {

        if (Session::has('token')) {
            $token = Session::get('token');

            if (null != $this->getUserId($token)) {
              return redirect()->route('dashboard.index');
            }

            return view('pages.auth.signin',['error' => Lang::get('validation.token_is_not_validated')]);

        }

        return view('pages.auth.signin');

    }

    public function signin (Request $request) {

      $this->validate(
        $request,
        Config::get('app.auth_rule'),
        Lang::get('validation.auth_validation_messages')
      );

      $username = $request->username;
      $password = $request->password;

      $data = User::where('USER_NAME', $username)->first ();
      $isValidatedData = count($data) > 0;

      if (!$isValidatedData) {
          return redirect ()->route('auth.index')->with('error',Lang::get('validation.not_found_account'));
      }

      $isPasswordMatched = ($password === $data->USER_PASSWORD);

      if (!$isPasswordMatched) {
          return redirect()->route('auth.index')->with('error',Lang::get('validation.not_matched_account'));
      }

      Session::put('token',$request->_token);
      Session::put('name',$data->USER_NAME);
      Session::put('email',$data->USER_EMAIL);
      Session::put('img', "");
      
      $data->USER_SECURITY_TOKEN = $request->_token;
      $data->save();

      return redirect()->route('dashboard.index');
    }

    public function signout () {

      if (Session::has('token')) {

          $data = User::find($this->getUserId(Session::get('token')));

          if ($data->count() > 0) {
              $data->USER_SECURITY_TOKEN = null;
              $data->save();
          }

          Session::flush();
          return redirect()->route('auth.index');
      }

    }

}
