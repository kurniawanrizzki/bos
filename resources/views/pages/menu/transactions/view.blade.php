@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.menuItems.transaction.title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.detailed_transaction') }}
                            <small>{!! trans('string.detailed_transaction_description',['number'=>$transaction[0]->TRANSACTION_NUMBER]) !!}</small>
                        </h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">{{ trans('string.menuItems.transaction.title') }}</h2>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[0] }}
                            </div>
                            <div class="col-md-8">
                              @if($transaction[0]->STATUS == 4)
                                <button class="btn btn-success waves-effect">
                                  {{ trans('string.delivered_status') }}
                                </button>
                              @elseif($transaction[0]->STATUS == 3)
                                <button class="btn btn-primary waves-effect">
                                  {{ trans('string.transfered_status') }}
                                </button>
                              @elseif($transaction[0]->STATUS == 2)
                                <button class="btn btn-danger waves-effect">
                                  {{ trans('string.paid_canceled_status') }}
                                </button>
                              @elseif($transaction[0]->STATUS == 1)
                                <button class="btn btn-danger waves-effect">
                                  {{ trans('string.canceled_status') }}
                                </button>
                              @elseif($transaction[0]->STATUS == 0)
                                  <button class="btn btn-info waves-effect">
                                    {{ trans('string.waiting_status') }}
                                </button>
                              @else
                                <button class="btn btn-warning waves-effect">
                                  {{ trans('string.unknown_status') }}
                                </button>
                              @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[1] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->CUSTOMER_NAME }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[2] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->ADDRESS." - ".$transaction[0]->DISTRICT." - ".$transaction[0]->PROVINCE }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[3] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->HP }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[4] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->TRANSACTION_NUMBER }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[5] }}
                            </div>
                            <div class="col-md-8">
                              @if ($transaction[0]->INVOICE_NUMBER != "")
                                {{ $transaction[0]->INVOICE_NUMBER }}
                              @else
                                <strong>
                                  <i>{{ trans('string.unavailable') }}</i>
                                </strong>
                              @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[6] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->TRANSACTION_DATE }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[7] }}
                            </div>
                            <div class="col-md-8">
                              {{ \Config::get('app.applied_curency').number_format($transaction[0]->TOTAL, 2) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[8] }}
                            </div>
                            <div class="col-md-8">
                              {{ $transaction[0]->SHIPPING_TYPE }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.transaction_detail_component')[9] }}
                            </div>
                            <div class="col-md-8">
                              {{ \Config::get('app.applied_curency').number_format($transaction[0]->SHIPPING_TOTAL, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                  <div class="header">
                    <h2>
                        {{ trans('string.detailed_orders') }}
                        <small>{!! trans('string.detailed_orders_description') !!}</small>
                    </h2>
                  </div>
                  <div class="body">
                    <div class="body table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              @foreach(trans('string.orders_table') as $title)
                                <th>{{$title}}</th>
                              @endforeach
                            </tr>
                          </thead>
                          <tbody>
                            @if(sizeof($orders) > 0)
                              @foreach($orders as $item)
                                <tr>
                                  <th scope="row">{{ $item->ITEM_CODE }}</th>
                                  <td>{{ $item->ITEM_NAME }}</td>
                                  <td>{{ $item->ITEM_SIZE }}</td>
                                  <td>{{ \Config::get('app.applied_curency').number_format($item->ITEM_PRICE, 2) }}</td>
                                  <td>{{ $item->TOTAL_ITEM }}</td>
                                  <td>{{ \Config::get('app.applied_curency').number_format($item->TOTAL_PRICE, 2) }}</td>
                                </tr>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="6" align="center">
                                  <strong>
                                    <i>{{ trans('string.data_is_empty') }}</i>
                                  </strong>
                                </td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection
