@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.menuItems.dashboard.title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> {{ trans('string.menuItems.dashboard.title') }} </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.transaction_dashboard_tb_title') }}
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                @foreach(trans('string.transactions_table') as $title)
                                  @if($title != 'ACTION')
                                    <th>{{$title}}</th>
                                  @endif
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @if(sizeof($transactions) > 0)
                                @foreach($transactions as $transaction)
                                  <tr>
                                      <th scope="row">{{ $transaction->TRANSACTION_NUMBER }}</th>
                                      <td>
                                        @if ($transaction->INVOICE_NUMBER != "")
                                          {{ $transaction->INVOICE_NUMBER }}
                                        @else
                                          <strong>
                                            <i>{{ trans('string.unavailable') }}</i>
                                          </strong>
                                        @endif
                                      </td>
                                      <td>{{ $transaction->TRANSACTION_DATE }}</td>
                                      <td>{{ $transaction->CUSTOMER_NAME }}</td>
                                      <td>
                                        @if($transaction->STATUS == 4)
                                          <button class="btn btn-success waves-effect">
                                            {{ trans('string.delivered_status') }}
                                          </button>
                                        @elseif($transaction->STATUS == 3)
                                          <button class="btn btn-primary waves-effect">
                                            {{ trans('string.transfered_status') }}
                                          </button>
                                        @elseif($transaction->STATUS == 2)
                                          <button class="btn btn-danger waves-effect">
                                            {{ trans('string.paid_canceled_status') }}
                                          </button>
                                        @elseif($transaction->STATUS == 1)
                                          <button class="btn btn-danger waves-effect">
                                            {{ trans('string.canceled_status') }}
                                          </button>
                                        @elseif($transaction->STATUS == 0)
                                            <button class="btn btn-info waves-effect">
                                              {{ trans('string.waiting_status') }}
                                          </button>
                                        @else
                                          <button class="btn btn-warning waves-effect">
                                            {{ trans('string.unknown_status') }}
                                          </button>
                                        @endif
                                      </td>
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
                        <small>
                          {!!
                            trans('string.goto_detail_page',[
                              'url'=>route(trans('string.menuItems.transaction.url')),
                              'title'=>trans('string.menuItems.transaction.title')
                            ])
                          !!}
                        .</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.item_dashboard_tb_title') }}
                            <!-- <small>Basic example without any additional modification classes</small> -->
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                @foreach(trans('string.items_table') as $title)
                                  @if($title != 'ACTION')
                                    <th>{{$title}}</th>
                                  @endif
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                              @if(sizeof($items) > 0)
                                @foreach($items as $item)
                                  <tr>
                                      <th scope="row">{{ $item->ITEM_CODE }}</th>
                                      <td>{{ $item->ITEM_NAME }}</td>
                                      <td>{{ $item->ITEM_SIZE }}</td>
                                      <td>{{ $item->ITEM_STOCK }}</td>
                                      <td>
                                        {{ \Config::get('app.applied_curency').number_format($item->ITEM_PRICE, 2) }}
                                      </td>
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
                        <small>
                          {!!
                            trans('string.goto_detail_page',[
                              'url'=>route(trans('string.menuItems.item.url')),
                              'title'=>trans('string.menuItems.item.title')
                            ])
                          !!}
                        .</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
