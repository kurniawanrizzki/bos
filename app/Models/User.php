<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = "USER";
  protected $primaryKey = "USER_ID";
  public $timestamps = false;
}
