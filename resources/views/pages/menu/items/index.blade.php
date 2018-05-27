@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.menuItems.item.title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> {{ trans('string.menuItems.item.title') }} </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                          {{ trans('string.item_tb_title') }}
                            <!-- <small>Basic example without any additional modification classes</small> -->
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                @foreach(trans('string.items_table') as $title)
                                  <th>{{$title}}</th>
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
                                      <td align="center">
                                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="#">
                                          <i class="material-icons">search</i>
                                        </a>
                                        <a class="btn bg-green btn-circle waves-effect waves-circle waves-float" href="#">
                                          <i class="material-icons">edit</i>
                                        </a>
                                        <a class="btn bg-red btn-circle waves-effect waves-circle waves-float" href="#">
                                          <i class="material-icons">delete</i>
                                        </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-large bg-green btn-circle-lg waves-effect waves-circle waves-float" href="#" style="position:fixed;right:0;bottom:0;margin:20px;">
      <i class="material-icons">add</i>
    </a>
</section>
@endsection
