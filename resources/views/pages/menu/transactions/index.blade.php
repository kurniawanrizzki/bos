@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.menuItems.transaction.title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> {{ trans('string.menuItems.transaction.title') }} </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.transaction_tb_title') }}
                        </h2>
                    </div>
                    <div class="body table-responsive" style="min-height:235px;">
                        <table class="table">
                            <thead>
                              <tr>
                                @foreach(trans('string.transactions_table') as $title)
                                  <th>{{$title}}</th>
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
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $transaction->TRANSACTION_ID }}">
                                        <div class="btn-group" role="group">
                                          <?php

                                            $color = $transaction->STATUS == 4?'btn-success':
                                                      ($transaction->STATUS == 3?btn-primary:
                                                        (($transaction->STATUS == 2) || ($transaction->STATUS == 1)?'btn-danger':
                                                          ($transaction->STATUS == 0?'btn-info':'btn-warning')));

                                          ?>
                                          <button type="button" class="btn waves-effect dropdown-toggle {{ $color }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" id="bos-status" {!! ($transaction->STATUS == 4) || ($transaction->STATUS == 2) || ($transaction->STATUS == 1)?'disabled':'' !!} >
                                            @if($transaction->STATUS == 4)
                                              {{ trans('string.delivered_status') }}
                                            @elseif($transaction->STATUS == 3)
                                              {{ trans('string.transfered_status') }}
                                            @elseif($transaction->STATUS == 2)
                                              {{ trans('string.paid_canceled_status') }}
                                            @elseif($transaction->STATUS == 1)
                                              {{ trans('string.canceled_status') }}
                                            @elseif($transaction->STATUS == 0)
                                              {{ trans('string.waiting_status') }}
                                            @else
                                              {{ trans('string.unknown_status') }}
                                            @endif
                                              <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu bos-status-dropdown">
                                              <li><a class=" waves-effect waves-block">{{ trans('string.delivered_status') }}</a></li>
                                              <li><a class=" waves-effect waves-block">{{ trans('string.transfered_status') }}</a></li>
                                              <li><a class=" waves-effect waves-block">{{ trans('string.canceled_status') }}</a></li>
                                          </ul>
                                        </div>
                                      </td>
                                      <td align="center">
                                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="{{route('transaction.view',[$transaction->TRANSACTION_ID])}}">
                                          <i class="material-icons">search</i>
                                        </a>
                                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="{{route('transaction.print',[$transaction->TRANSACTION_ID])}}">
                                          <i class="material-icons">print</i>
                                        </a>
                                        <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="{{route('transaction.delete',[$transaction->TRANSACTION_ID])}}">
                                          <i class="material-icons">delete</i>
                                        </a>
                                      <td>
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
</section>
@endsection
