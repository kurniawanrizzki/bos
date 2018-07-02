@extends("layouts.dashboards.sidebar")
@section("dashboard.title", trans('string.profile_edit'))
@section("dashboard.content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> {{ trans('string.profile_edit') }} </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ trans('string.profile_edit') }}
                            <small>{!! $user[0]->USER_NAME.' - '.$user[0]->USER_EMAIL !!}</small>
                        </h2>
                    </div>
                    <div class="body">
                        {!! Form::open([
                          'method' => 'POST',
                          'route' => 'profile.update',
                          'id' => 'profile-form'
                          ]) !!}

                            {{ csrf_field() }}
                        
                            <div class="row">
                                <div class="col-md-3">
                                {{ trans('string.user_detail_component')[0] }}
                                </div>
                                <div class="col-md-8">
                                {!! $user[0]->USER_NAME.'<br>' !!}
                                <small>{!! trans('string.contacting_desc') !!}</small>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                @if(null !== $errors->first('profile_address'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('profile_address') }}</strong> </span>
                                @endif
                                <div class="form-group form-float" {{ (null !== $errors->first('profile_address')?'style=margin-top:10px;':'') }}>
                                    <div class="form-line">
                                        {!! Form::textarea('profile_address',null === old('profile_address')?$user[0]->USER_ADDRESS:old('profile_address'),['class'=>'form-control no-resize','rows'=>4,'required']) !!}
                                        {!! Form::label('profile_address',trans('string.user_detail_component')[1],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                @if(null !== $errors->first('profile_email'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('profile_email') }}</strong> </span>
                                @endif
                                <div class="form-group form-float" {{ (null !== $errors->first('profile_email')?'style=margin-top:10px;':'') }}>
                                    <div class="form-line">
                                        {!! Form::text('profile_email',null === old('profile_email')?$user[0]->USER_EMAIL:old('profile_email'),['class'=>'form-control','required autofocus']) !!}
                                        {!! Form::label('profile_email',trans('string.user_detail_component')[2],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                @if(null !== $errors->first('profile_hp'))
                                  <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('profile_hp') }}</strong> </span>
                                @endif
                                <div class="form-group form-float" {{ (null !== $errors->first('profile_hp')?'style=margin-top:10px;':'') }}>
                                    <div class="form-line">
                                        {!! Form::text('profile_hp',null === old('profile_hp')?$user[0]->USER_HP:old('profile_hp'),['class'=>'form-control','required autofocus']) !!}
                                        {!! Form::label('profile_hp',trans('string.user_detail_component')[3],['class'=>'form-label']) !!}
                                    </div>
                                </div>
                              </div>
                            </div>
                            <h2 class="card-inside-title">{{ trans('string.user_detail_component')[4] }}</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('item_size',trans('string.open_po'),['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                    @if(null !== $errors->first('profile_open_po'))
                                    <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('profile_open_po') }}</strong> </span>
                                    @endif
                                    <div class="input-group" {{ (null !== $errors->first('profile_open_po')?'style=margin-top:10px;':'') }}>
                                        <div class="form-line">
                                            {!! Form::text('profile_open_po',null === old('profile_open_po')?$user[0]->USER_OPEN_TIME:old('profile_open_po'),['class'=>'form-control text-right','required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('profile_close_po',trans('string.closed_po'),['class'=>'form-label','style'=>'font-size:12px;color:#aaa;font-weight:normal']) !!}
                                    @if(null !== $errors->first('profile_close_po'))
                                    <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('profile_close_po') }}</strong> </span>
                                    @endif
                                    <div class="input-group" {{ (null !== $errors->first('profile_close_po')?'style=margin-top:10px;':'') }}>
                                        <div class="form-line">
                                            {!! Form::text('profile_close_po',null === old('profile_close_po')?$user[0]->USER_CLOSE_TIME:old('profile_close_po'),['class'=>'form-control text-right','required']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-2">
                              <a href="{{route('profile.index')}}" class="btn btn-block btn-md btn-warning waves-effect">
                                <i class="material-icons">arrow_back_ios</i>
                                <span>{{ trans('string.back') }}</span>
                              </a>
                            </div>
                            <div class="col-md-10">
                              {!! Form::submit(trans('string.profile_edit'), ['class'=>'btn btn-block btn-lg btn-success waves-effect']) !!}
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
