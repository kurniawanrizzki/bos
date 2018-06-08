<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style rel="stylesheet">

  table {
    font-family: "Sans-serif";
    font-size: 10pt;
    border: 1px solid black;
    border-collapse: collapse;
  }

  th, td {
    padding: 3px;
  }

  .border-col-body {
    border-bottom: 1px solid black;
    border-right: 1px solid black;
  }

  .border-col-head {
    border-top:1px solid black;
  }

  item {
    padding-left:20px;
  }

  </style>
  <body>
    @foreach($transactions as $item)
    <table width="100%" style="margin-top:15px;">
      <tr>
        <th class="border-col-body" width="10%">FROM</th>
        <td width="60%" class="border-col-body">{{ \Session::get('name') }}</td>
        <td class="border-col-body" align="center">{{ $item['transaction'][0]->SHIPPING_TOTAL_WEIGHT." Kg (Shipping : ".$item['transaction'][0]->SHIPPING_TYPE.") " }}</td>
      </tr>
      <tr>
        <th rowspan="4">TO</th>
        <td colspan="2" class="ignorebottomborder">{{ $item['transaction'][0]->CUSTOMER_NAME }}</td>
      </tr>
      <tr>
        <td colspan="2" style="outline:none;">{{ $item['transaction'][0]->ADDRESS }}</td>
      </tr>
      <tr>
        <td colspan="2">Kecamatan : {{ $item['transaction'][0]->DISTRICT.", ".$item['transaction'][0]->PROVINCE }}</td>
      </tr>
      <tr>
        <td colspan="2">Telp: {{ $item['transaction'][0]->HP }}</td>
      </tr>
      <tr>
        <td colspan="3" class="border-col-head">Order ( {{ $item['transaction'][0]->TRANSACTION_NUMBER }} )</td>
      </tr>
      @foreach($item['orders'] as $order)
        <tr>
          <td colspan="2">
            <item>{{ $order->ITEM_NAME." ".$order->ITEM_SIZE }}</item>
          </td>
          <td align="right" style="padding-right:20px;">{{ $order->TOTAL_ITEM }} Items</td>
        </tr>
      @endforeach
    </table>
    @endforeach
  </body>
</html>
