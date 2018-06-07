<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style rel="stylesheet">
    .noborder {border: none;}
    .content {font-size: 9px;}
  </style>
  <body>
    @foreach($transactions as $transaction)
      <div class="content">
        <table cellspacing="0" cellpadding="0" class="noborder">
          <tr>
            <td>{{ $transaction["transaction"][0]->TRANSACTION_DATE }}</td>
          </tr>
          <tr>
            <td><strong>Service</strong></td>
            <td> <strong>:</strong> </td>
            <td>{{ $transaction["transaction"][0]->SHIPPING_TYPE }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Weight</strong></td>
            <td> <strong>:</strong> </td>
            <td>{{ $transaction["transaction"][0]->SHIPPING_TOTAL_WEIGHT." Kg" }}</td>
          </tr>
        </table>
        <table cellspacing="0" cellpadding="0" class="noborder" style="margin:25px 0 0">
          <tr>
            <td> <strong> Sender Information </strong> </td>
          </tr>
          <tr>
            <td> <strong>Name</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ \Session::get('name') }} </td>
          </tr>
          <tr>
            <td> <strong>Address</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ \Session::get('address') }} </td>
          </tr>
          <tr>
            <td> <strong>Phone Number</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ \Session::get('hp') }} </td>
          </tr>
        </table>
        <table cellspacing="0" cellpadding="0" class="noborder" style="margin:25px 0 0">
          <tr>
            <td> <strong> Recipient Information </strong> </td>
          </tr>
          <tr>
            <td> <strong>Name</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ $transaction["transaction"][0]->CUSTOMER_NAME }} </td>
          </tr>
          <tr>
            <td> <strong>Address</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ $transaction["transaction"][0]->ADDRESS." - ".$transaction["transaction"][0]->DISTRICT." - ".$transaction["transaction"][0]->PROVINCE }} </td>
          </tr>
          <tr>
            <td> <strong>Phone Number</strong> </td>
            <td> <strong>:</strong> </td>
            <td> {{ $transaction["transaction"][0]->HP }} </td>
          </tr>
        </table>
        @if(sizeof($transaction["orders"]) > 0)
        <table style="margin:25px 0 0" width='100%'>
          <tr>
            <td> <strong> Detail Items </strong> </td>
          </tr>
          <tr>
              <th>Code</th>
              <th>Name</th>
              <th>Size</th>
              <th>Weight</th>
              <th>Total Item</th>
          </tr>
          @foreach($transaction["orders"] as $order)
            <tr>
              <td>{{ $order->ITEM_CODE }}</td>
              <td>{{ $order->ITEM_NAME }}</td>
              <td>{{ $order->ITEM_SIZE }}</td>
              <td>{{ $order->ITEM_WEIGHT }}</td>
              <td>{{ $order->ITEM_TOTAL_ITEM }}</td>
            </tr>
          @endforeach
        </table>
        @endif
      </div>
    @endforeach
  </body>
</html>
