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
                        <table class="table table-bordered table-striped table-hover dataTable" id="items_tb" width="100%">
                            <thead>
                              <tr>
                                @foreach(trans('string.items_table') as $title)
                                  <th>{{$title}}</th>
                                @endforeach
                              </tr>
                            </thead>
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
