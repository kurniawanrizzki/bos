<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
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
      $this->validate ($request,Config::get('app.item_rule'), Lang::get('validation.item_validation_messages'));

      $findItemSizeCode = Item::where('ITEM_CODE','=',$request->item_code)
            ->where('ITEM_SIZE','=',$request->item_size)
            ->select('ITEM_ID')->get();
      
      if ($findItemSizeCode->count() > 0) {
        $id = $findItemSizeCode[0]->ITEM_ID;
        $find = Item::find($id);
        return view('pages.menu.items.form',[
          'item'=>$find,
          'error' => Lang::get('validation.item_was_existed')
          ]);
      }

      $parameter = $this->buildRequestParameters($request);
      Item::insert($parameter);
      return redirect()->route('item.index');
    }

    public function update (Request $request) {
      $rules = Config::get('app.item_rule');
      $rules['item_name'] = $rules['item_name'].",".$request->item_id.",ITEM_ID";
      $this->validate ($request,$rules, Lang::get('validation.item_validation_messages'));
      $parameter = $this->buildRequestParameters($request);
      Item::where('ITEM_ID',$parameter['ITEM_ID'])->update($parameter);
      return redirect()->route('item.index');
    }

    public function getItemList (Request $request) {

        $this->validate($request, Config::get('app.request_rule'));
        $userId = $this->getUserId($request->token);

        if (null != $userId) {
          $search = Input::get('search.value');
          $items = Item::where('USER_ID','=',$userId);

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
                          <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-product-id="'.$items->ITEM_ID.'" data-product-name="'.$items->ITEM_CODE.' - '.$items->ITEM_NAME.'" data-target="#delete_confirmation_modal">
                              <i class="material-icons">delete</i>
                          </a>';
                })
                ->rawColumns(['ACTION','PRICE'])
                ->make();
        }

        return response()->json([
          'reason' => Lang::get('validation.token_is_not_validated'),
          'data' => []
        ]);
    }

    protected function buildRequestParameters (Request $request) {

        $userId = $this->getUserId(Session::get('token'));

        $price  = str_replace(",","",$request->item_price);
        $parameter = [
            'ITEM_CODE' => $request->item_code,
            'USER_ID'   => $userId,
            'ITEM_NAME' => $request->item_name,
            'ITEM_DESC' => $request->item_desc,
            'ITEM_SIZE' => $request->item_size,
            'ITEM_WEIGHT'=> $request->item_weight,
            'ITEM_PRICE'=> $price,
            'ITEM_STOCK' => $request->item_stock
        ];

        if (isset($request->item_id)) {
            $parameter['ITEM_ID'] = $request->item_id;
        }

        return $parameter;

    }

}
