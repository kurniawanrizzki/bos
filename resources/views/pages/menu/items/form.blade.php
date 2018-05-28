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
                        {!! Form::open([
                          'method' => 'POST',
                          'route' => !isset($item)?'item.store':'item.update'
                          ]) !!}

                          {{ csrf_field() }}
                          <div class="row">
                              <div class="col-md-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        @if(isset($item))
                                          {!! Form::hidden('item_id',isset($item)?$item->ITEM_ID:'',['class'=>'form-control']) !!}
                                        @endif
                                        {!! Form::text('item_code',isset($item)?$item->ITEM_CODE:'',['class'=>'form-control']) !!}
                                        {!! Form::label('item_code',trans('string.item_detail_component')[0],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group form-float">
                                  <div class="form-line">
                                      {!! Form::text('item_name',isset($item)?$item->ITEM_NAME:'',['class'=>'form-control']) !!}
                                      {!! Form::label('item_name',trans('string.item_detail_component')[1],['class'=>'form-label']) !!}
                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group form-float">
                                  <div class="form-line">
                                      {!! Form::textarea('item_desc',isset($item)?$item->ITEM_DESC:'',['class'=>'form-control no-resize','rows'=>4]) !!}
                                      {!! Form::label('item_desc',trans('string.item_detail_component')[2],['class'=>'form-label']) !!}
                                  </div>
                              </div>
                            </div>
                          </div>
                          <h2 class="card-inside-title">{{ trans('string.item_size_weight') }}</h2>
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {!! Form::text('item_size',isset($item)?$item->ITEM_SIZE:'',['class'=>'form-control']) !!}
                                        {!! Form::label('item_size',trans('string.item_detail_component')[3],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {!! Form::text('item_weight',isset($item)?$item->ITEM_WEIGHT:'',['class'=>'form-control']) !!}
                                        {!! Form::label('item_weight',trans('string.item_detail_component')[4],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                          </div>
                          <h2 class="card-inside-title">{{ trans('string.item_availability') }}</h2>
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {!! Form::text('item_price',isset($item)?$item->ITEM_PRICE:'',['class'=>'form-control']) !!}
                                        {!! Form::label('item_price',trans('string.item_detail_component')[5],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        {!! Form::text('item_stock',isset($item)?$item->ITEM_STOCK:'',['class'=>'form-control']) !!}
                                        {!! Form::label('item_stock',trans('string.item_detail_component')[6],['class'=>'form-label']) !!}
                                    </div>
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
