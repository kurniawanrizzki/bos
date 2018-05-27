<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index () {
      return view('pages.menu.items.index');
    }

    public function getItemList () {
        $search = Input::get('search.value');
        $items = Item::where('USER_ID','=',$this->getUserId());

        if (!empty($search)) {
          $filtered = "%".$search."%";
          $items = $items->where('ITEM_NAME','LIKE',$filtered)
                  ->orWhere('ITEM_CODE','LIKE',$filtered)
                  ->orWhere('ITEM_DESC','LIKE',$filtered)
                  ->orwhere('ITEM_STOCK','LIKE',$filtered)
                  ->orwhere('ITEM_SIZE','LIKE',$filtered)
                  ->orwhere('ITEM_PRICE','LIKE',$filtered);

        }

        return \DataTables::of($items)
              ->addColumn('PRICE', function($items){
                return \Config::get('app.applied_curency').number_format($items->ITEM_PRICE, 2);
              })
              ->addColumn('ACTION', function($items){
                return '<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="#">
                            <i class="material-icons">search</i>
                        </a>
                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="#">
                            <i class="material-icons">edit</i>
                        </a>
                        <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="#">
                            <i class="material-icons">delete</i>
                        </a>';
              })
              ->rawColumns(['ACTION','PRICE'])
              ->make();
    }

}
