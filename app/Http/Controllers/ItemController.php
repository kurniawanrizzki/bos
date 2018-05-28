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

    public function view ($itemId) {
      $item = Item::find($itemId);
      return view('pages.menu.items.view',['item'=>$item]);
    }

    public function delete ($itemId) {
      $item = Item::find($itemId);

      if ($item->count() > 0) {
        $item->delete();
        return redirect()->route('item.index');
      }
      return abort(404);
    }

    public function form ($itemId = null) {
      if (null != $itemId) {
        $find = Item::find($itemId);
        if($find->count() > 0) {
          return view('pages.menu.items.form',['item'=>$find]);
        }
        return abort(404);
      }
      return view('pages.menu.items.form');
    }

    public function store (Request $request) {
      $parameter = $this->buildRequestParameters($request);
      Item::insert($parameter);
      return redirect()->route('item.index');
    }

    public function update (Request $request) {
      $parameter = $this->buildRequestParameters($request);
      Item::where('ITEM_ID',$parameter['ITEM_ID'])->update($parameter);
      return redirect()->route('item.index');
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
                return '<a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="'.route('item.view',[$items->ITEM_ID]).'">
                            <i class="material-icons">search</i>
                        </a>
                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="'.route('item.form',[$items->ITEM_ID]).'">
                            <i class="material-icons">edit</i>
                        </a>
                        <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="'.route('item.delete',[$items->ITEM_ID]).'">
                            <i class="material-icons">delete</i>
                        </a>';
              })
              ->rawColumns(['ACTION','PRICE'])
              ->make();
    }

    protected function buildRequestParameters (Request $request) {

        $parameter = [
            'ITEM_CODE' => $request->item_code,
            'USER_ID'   => $this->getUserId(),
            'ITEM_NAME' => $request->item_name,
            'ITEM_DESC' => $request->item_desc,
            'ITEM_SIZE' => $request->item_size,
            'ITEM_WEIGHT'=> $request->item_weight,
            'ITEM_PRICE'=> $request->item_price,
            'ITEM_STOCK' => $request->item_stock
        ];

        if (isset($request->item_id)) {
            $parameter['ITEM_ID'] = $request->item_id;
        }

        return $parameter;

    }

}
