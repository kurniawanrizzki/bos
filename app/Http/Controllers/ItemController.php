<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index () {
      $items = $this->getLastItem();
      return view('pages.menu.items.index', [
        'items' => $items
      ]);
    }

    protected function getLastItem () {
        $items = Item::orderBy('ITEM_ID','DESC')
                ->where('USER_ID','=',$this->getUserId());
        return $items->get();
    }

}
