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
  'items_table' => ['CODE','NAME','SIZE','STOCK','PRICE'],
  'item_detail_component'=>['CODE','NAME','DESCRIPTION','SIZE','WEIGHT (*Kg)','PRICE (*/Pcs)','STOCK (*Pcs)'],
  'transactions_table'=> ['TRANSACTION NUMBER','INVOICE NUMBER','DATE','CUSTOMER NAME','STATUS'],
  'transaction_detail_component' => ['STATUS','STATUS STATE','CUSTOMER NAME','CUSTOMER ADDRESS','CUSTOMER PHONE','TRANSACTION NUMBER','INVOICE NUMBER','DATE','TOTAL ORDER','SHIPPING TYPE','SHIPPING TOTAL','SHIPPING TOTAL WEIGHT'],
  'goto_detail_page' => "For the detail please go to <a href=' :url '> :title </a> page.",
  'delivered_status' => 'DELIVERED',
  'transfered_status' => 'TRANSFERED',
  'waiting_status' => 'WAITING',
  'canceled_status' => 'CANCELED',
  'paid_canceled_status' => 'CANCELED (WAS TRANSFERED)',
  'unknown_status' => 'UNKNOWN',
  'all_status' => 'ALL',
  'transaction_detailed' => 'Transaction Detail For <strong> :number </strong>',
  'detailed_transaction' => 'DETAILED TRANSACTION',
  'detailed_transaction_description' => 'This section will describe detail transaction of  <strong> :number </strong>.',
  'detailed_orders' => 'DETAILED ORDER',
  'detailed_orders_description' => 'This section will describe detail order of  related transaction.',
  'detailed_item' => 'DETAILED PRODUCT',
  'detailed_item_description' => 'This section will describe detail product of <strong> :code - :item </strong>.',
  'data_is_empty' => 'Data is Empty.',
  'item_size_weight' => 'Size and Weight',
  'item_availability' => 'Price and Stock',
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
  'confirmation_modal_title' => ':title Confirmation',
  'signout_confirmation_modal_content' => 'Do you want to sign out from this session ?',
  'confirm_button' => 'Confirm',
  'cancel_button' => 'Cancel',
  'status_list' => ['C','T','D'],
  'error_default' => 'This page doesn\'t exist',
  'internal_error' => 'Internal Server Error',
  'not_allowed_method' => 'Method Not Allowed',
  'goback' => 'Go to Home Page'
];
