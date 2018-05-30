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
                            {{ trans('string.detailed_item') }}
                            <small>{!! trans('string.detailed_item_description',['code'=>$item->ITEM_CODE,'item'=>$item->ITEM_NAME]) !!}</small>
                        </h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">{{ trans('string.menuItems.item.title') }}</h2>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.item_detail_component')[0] }}
                            </div>
                            <div class="col-md-8">
                              {{ $item->ITEM_CODE }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.item_detail_component')[1] }}
                            </div>
                            <div class="col-md-8">
                              {{ $item->ITEM_NAME }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.item_detail_component')[2] }}
                            </div>
                            <div class="col-md-8">
                              {{ $item->ITEM_DESC }}
                            </div>
                        </div>
                        <h2 class="card-inside-title">{{ trans('string.item_size_weight') }}</h2>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-3">
                                    {{ trans('string.item_detail_component')[3] }}
                                  </div>
                                  <div class="col-md-8">
                                    {{ $item->ITEM_SIZE }}
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-3">
                                    {{ trans('string.item_detail_component')[4] }}
                                  </div>
                                  <div class="col-md-8">
                                    {{ $item->ITEM_WEIGHT." Kg" }}
                                  </div>
                              </div>
                            </div>
                        </div>
                        <h2 class="card-inside-title">{{ trans('string.item_availability') }}</h2>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-3">
                                    {{ trans('string.item_detail_component')[5] }}
                                  </div>
                                  <div class="col-md-8">
                                    {{ \Config::get('app.applied_curency').number_format($item->ITEM_PRICE, 2) }}
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-3">
                                    {{ trans('string.item_detail_component')[6] }}
                                  </div>
                                  <div class="col-md-8">
                                    {{ $item->ITEM_STOCK." Pcs" }}
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
