<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "ITEM";
    protected $primaryKey = "ITEM_ID";
    public $timestamps = false;
}
