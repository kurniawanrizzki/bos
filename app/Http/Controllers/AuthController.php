<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    /**
     * Initiate welcome page;
     */
    public function index () {

        if (Session::get('login')) {
            return redirect()->route('dashboard.index');
        }

        return view('pages.auth.signin');

    }

    public function signin (Request $request) {
      $username = $request->username;
      $password = $request->password;

      $data = User::where('USER_NAME', $username)->first ();
      $isValidatedData = count($data) > 0;
      $isPasswordMatched = ($password === $data->USER_PASSWORD);

      if (!$isValidatedData) {
          return redirect ()->route('auth.index');
      }

      if (!$isPasswordMatched) {
          return redirect()->route('auth.index');
      }

      Session::put('id', $data->USER_ID);
      Session::put('login', TRUE);
      Session::put('token',$request->_token);

      return redirect()->route('dashboard.index');
    }

    public function signout () {

      if (Session::has('id') && Session::has('token') && Session::has('login')) {
          Session::flush();
          return redirect()->route('auth.index');
      }

    }

}
