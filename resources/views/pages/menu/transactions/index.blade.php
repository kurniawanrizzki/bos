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
                        <table class="table table-bordered table-striped table-hover dataTable" id="transactions_tb" width="100%">
                            <thead>
                              <tr>
                                @foreach(trans('string.transactions_table') as $title)
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
</section>
@endsection
