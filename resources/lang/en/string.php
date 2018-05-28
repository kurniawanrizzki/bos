<?php

return [
  'menu' => 'Menu',
  'menuItems' => [
    'dashboard' => [
      'title' => 'Dashboard',
      'icon' => 'home',
      'url' => 'dashboard.index',
      'prefix' => 'dashboard'
    ],
    'transaction' => [
      'title' => 'Transaction',
      'icon' => 'receipt',
      'url' => 'transaction.index',
      'prefix' => 'transaction'
    ],
    'item' => [
      'title' => 'Product',
      'icon' => 'local_offer',
      'url' => 'item.index',
      'prefix' => 'item'
    ]
  ],
  'auth' => [
    'title' => 'Sign In',
    'subtitle' => 'Connecting your business easily  .',
    'welcome' => 'Sign in to start your session',
    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'username' => 'Username',
    'password' => 'Password',
    'rememberme' => 'Remember Me'
  ],
  'unavailable' => 'UNAVAILABLE',
  'item_dashboard_tb_title' => 'Last '.\Config::get('app.limited_fetch_data').' Products',
  'item_tb_title' => 'Products List',
  'transaction_dashboard_tb_title' => 'Last '.\Config::get('app.limited_fetch_data').' Transactions',
  'transaction_tb_title' => 'Transactions List',
  'orders_table' => ['CODE','NAME','SIZE','PRICE','TOTAL ITEM','TOTAL PRICE'],
  'items_table' => ['CODE','NAME','SIZE','STOCK','PRICE','ACTION'],
  'item_detail_component'=>['CODE','NAME','DESCRIPTION','SIZE','WEIGHT','PRICE','STOCK'],
  'transactions_table'=> ['TRANSACTION NUMBER','INVOICE NUMBER','DATE','CUSTOMER NAME','STATUS','ACTION'],
  'transaction_detail_component' => ['STATUS','STATE STATUS','CUSTOMER NAME','CUSTOMER ADDRESS','CUSTOMER PHONE','TRANSACTION NUMBER','INVOICE NUMBER','DATE','TOTAL ORDER','SHIPPING TYPE','SHIPPING TOTAL'],
  'goto_detail_page' => "For the detail please go to <a href=' :url '> :title </a> page.",
  'delivered_status' => 'DELIVERED',
  'transfered_status' => 'TRANSFERED',
  'waiting_status' => 'WAITING',
  'canceled_status' => 'CANCELED',
  'paid_canceled_status' => 'CANCELED (WAS TRANSFERED)',
  'unknown_status' => 'UNKNOWN',
  'transaction_detailed' => 'Transaction Detail For <strong> :number </strong>',
  'detailed_transaction' => 'DETAILED TRANSACTION',
  'detailed_transaction_description' => 'This section will describe detail transaction of  <strong> :number </strong>.',
  'detailed_orders' => 'DETAILED ORDER',
  'detailed_orders_description' => 'This section will describe detail order of  related transaction.',
  'detailed_item' => 'DETAILED PRODUCT',
  'detailed_item_description' => 'This section will describe detail product of <strong> :code - :item </strong>.',
  'data_is_empty' => 'Data is Empty.',
  'item_size_weight' => 'Size and Weight',
  'item_availability' => 'Availability',
  'item_add' => 'Add New Product',
  'item_add_description' => 'This section allow user to add new product',
  'item_edit' => 'Edit Product',
  'item_edit_description' => 'This section allow user to edit <strong> :code - :item </strong>.',
  'back' => 'Back',
  'transaction_actions' => [
    'edit' => [
      'title' => 'Edit',
      'url' => '#'
    ],
    'print' => [
      'title' => 'Print Invoice',
      'url' => '#'
    ]
  ],
];
