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
                      <div class="row clearfix">
                        <div class="col-md-3">
                          <h2>
                              {{ trans('string.transaction_tb_title') }}
                          </h2>
                        </div>
                        <div class="col-md-9">
                          <div class="pull-right">
                            {!! Form::label('status',trans('string.transactions_table')[4],['class'=>'form-label','style'=>'font-color:#111;']) !!}
                            <div class="input-group">
                              <div class="form-line">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn bg-blue-grey waves-effect filter-btn">{{ trans('string.all_status') }}</button>
                                    <button type="button" class="btn btn-info waves-effect filter-btn">{{ trans('string.canceled_status') }}</button>
                                    <button type="button" class="btn btn-info waves-effect filter-btn">{{ trans('string.transfered_status') }}</button>
                                    <button type="button" class="btn btn-info waves-effect filter-btn">{{ trans('string.delivered_status') }}</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="body table-responsive" style="min-height:235px;">
                        <table class="table table-bordered table-striped table-hover dataTable" id="transactions_tb" width="100%">
                          <thead>
                            <tr>
                              <th rowspan="2">
                                <input type="checkbox" id="print_all_selection" value="0" class="filled-in"/>
                                <label for="print_all_selection"></label>
                              </th>
                              @foreach(trans('string.transactions_table') as $title)
                                @if($title != 'STATUS')
                                  <th rowspan="2">{{$title}}</th>
                                @else
                                  <th colspan="3" style="text-align: center;border-bottom-color: transparent;">{{$title}}</th>
                                @endif
                              @endforeach
                            </tr>
                            <tr>
                              @foreach(trans('string.status_list') as $status)
                                <th>{{$status}}</th>
                              @endforeach
                            </tr>
                          </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
