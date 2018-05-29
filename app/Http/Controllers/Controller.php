<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getUserId ($token) {
      $userId = null;

      $query = User::select('USER_ID')->where('USER_SECURITY_TOKEN',$token);
      if ($query->count() > 0) {
        $userId = $query->get()[0]->USER_ID;
      }

      return $userId;
    }

}
