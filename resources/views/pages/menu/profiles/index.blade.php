@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.profile_title'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> {{ trans('string.profile_title') }} </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.profile_title') }}
                            <small>{!! $user[0]->USER_NAME.' - '.$user[0]->USER_EMAIL !!}</small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ route('profile.edit') }}" class=" waves-effect waves-block">{{ trans('string.profile_edit') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.user_detail_component')[0] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.user_detail_component')[1] }}
                            </div>
                            <div class="col-md-8">
                              {{ $user[0]->USER_ADDRESS }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.user_detail_component')[2] }}
                            </div>
                            <div class="col-md-8">
                              {{ $user[0]->USER_EMAIL }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.user_detail_component')[3] }}
                            </div>
                            <div class="col-md-8">
                              {{ $user[0]->USER_HP }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                              {{ trans('string.user_detail_component')[4] }}
                            </div>
                            <div class="col-md-8">
                              {{ $user[0]->USER_OPEN_TIME.' - '.$user[0]->USER_CLOSE_TIME }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
