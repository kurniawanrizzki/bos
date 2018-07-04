@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.menuItems.item.title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ isset($item)? trans('string.item_edit'):trans('string.item_add') }}
                            <small>
                              {!! isset($item)? trans('string.item_edit_description',['code'=>$item->ITEM_CODE,'item'=>$item->ITEM_NAME]):trans('string.item_add_description') !!}
                            </small>
                        </h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">{{ trans('string.menuItems.item.title') }}</h2>
                        @if(isset($error))
                          <span style="color:#F44336;font-size:12px;"> <strong>{{ $error }}</strong> </span>
                        @endif
                        {!! Form::open([
                          'method' => 'POST',
                          'route' => !isset($item)?'item.store':'item.update',
                          'id' => 'item-form'
                          ]) !!}

                          {{ csrf_field() }}
                          <div class="row">
                              <div class="col-md-12">
                                @if(null !== $errors->first('item_code'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_code') }}</strong> </span>
                                @endif
                                <div class="form-group form-float" {{ (null !== $errors->first('item_code')?'style=margin-top:10px;':'') }}>
                                    <div class="form-line">
                                        @if(isset($item))
                                          {!! Form::hidden('item_id',isset($item)?$item->ITEM_ID:'',['class'=>'form-control']) !!}
                                        @endif
                                        {!! Form::text('item_code',isset($item)?$item->ITEM_CODE:old('item_code'),['class'=>'form-control','required autofocus']) !!}
                                        {!! Form::label('item_code',trans('string.item_detail_component')[0],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              @if(null !== $errors->first('item_name'))
                                <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_name') }}</strong> </span>
                              @endif
                              <div class="form-group form-float" {{ (null !== $errors->first('item_name')?'style=margin-top:10px;':'') }}>
                                  <div class="form-line">
                                      {!! Form::text('item_name',isset($item)?$item->ITEM_NAME:old('item_name'),['class'=>'form-control','required']) !!}
                                      {!! Form::label('item_name',trans('string.item_detail_component')[1],['class'=>'form-label']) !!}
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              @if(null !== $errors->first('item_desc'))
                                <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_desc') }}</strong> </span>
                              @endif
                              <div class="form-group form-float" {{ (null !== $errors->first('item_desc')?'style=margin-top:10px;':'') }}>
                                  <div class="form-line">
                                      {!! Form::textarea('item_desc',isset($item)?$item->ITEM_DESC:old('item_desc'),['class'=>'form-control no-resize','rows'=>4,'required']) !!}
                                      {!! Form::label('item_desc',trans('string.item_detail_component')[2],['class'=>'form-label']) !!}
                                  </div>
                              </div>
                            </div>
                          </div>
                          <h2 class="card-inside-title">{{ trans('string.item_size_weight') }}</h2>
                          <div class="row">
                              <div class="col-md-6">
                                {!! Form::label('item_size',trans('string.item_detail_component')[3],['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                @if(null !== $errors->first('item_size'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_size') }}</strong> </span>
                                @endif
                                <div class="input-group">
                                    <div class="form-line">
                                        {!! Form::text('item_size',isset($item)?$item->ITEM_SIZE:old('item_size'),['class'=>'form-control text-right','required']) !!}
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                {!! Form::label('item_weight',trans('string.item_detail_component')[4],['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                @if(null !== $errors->first('item_weight'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_weight') }}</strong> </span>
                                @endif
                                <div class="input-group spinner" data-trigger="spinner">
                                  <div class="form-line">
                                      {!! Form::text('item_weight',isset($item)?$item->ITEM_WEIGHT:old('item_weight'),['class'=>'form-control text-right','data-rule'=>'currency']) !!}
                                  </div>
                                  <span class="input-group-addon">
                                      <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                      <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                  </span>
                                </div>
                              </div>
                          </div>
                          <h2 class="card-inside-title">{{ trans('string.item_availability') }}</h2>
                          <div class="row">
                              <div class="col-md-6">
                                {!! Form::label('item_price',trans('string.item_detail_component')[5],['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                @if(null !== $errors->first('item_price'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_price') }}</strong> </span>
                                @endif
                                <div class="input-group">
                                    <div class="form-line">
                                      {!! Form::text('item_price',isset($item)?$item->ITEM_PRICE:(null !== old('item_price')?old('item_price'):'1000'),['class'=>'form-control text-right']) !!}
                                    </div>
                                    <span class="input-group-addon">{{ \Config::get('app.applied_curency') }}</span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                {!! Form::label('item_stock',trans('string.item_detail_component')[6],['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                @if(null !== $errors->first('item_stock'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('item_stock') }}</strong> </span>
                                @endif
                                <div class="input-group spinner" data-trigger="spinner">
                                  <div class="form-line">
                                      {!! Form::text('item_stock',isset($item)?$item->ITEM_STOCK:old('item_stock'),['class'=>'form-control text-right','data-rule'=>'quantity','data-min'=>'0']) !!}
                                  </div>
                                  <span class="input-group-addon">
                                      <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                      <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                  </span>
                                </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                              <a href="{{route('item.index')}}" class="btn btn-block btn-md btn-warning waves-effect">
                                <i class="material-icons">arrow_back_ios</i>
                                <span>{{ trans('string.back') }}</span>
                              </a>
                            </div>
                            <div class="col-md-10">
                              {!! Form::submit(isset($item)? trans('string.item_edit'):trans('string.item_add'), ['class'=>'btn btn-block btn-lg btn-success waves-effect']) !!}
                            </div>
                          </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
