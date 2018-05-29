@extends('layouts.app')
@section('title')
    @parent
    {{ trans('string.auth.title') }}
@endsection

@section('content')
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">Admin<b>{{ env('APP_NAME') }}</b></a>
        <small>{{ trans('string.auth.subtitle') }}</small>
    </div>
    <div class="card">
        <div class="body">
          {!!
            Form::open([
            'method' => 'POST',
            'route' => 'auth.signin',
            'id'   => 'sign_in'
            ])
          !!}

            <div class="msg">{{ trans('string.auth.welcome') }}</div>
            @if(null !== $errors->first('username'))
              <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('username') }}</strong> </span>
            @endif
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                    {!!
                      Form::text('username', old('username'), [
                        'class' => 'form-control',
                        'placeholder' => trans('string.auth.username'),
                        'required autofocus'
                      ])
                    !!}
                </div>
            </div>
            @if(null !== $errors->first('password'))
              <span style="color:#F44336;font-size:12px;"> <strong>{{ $errors->first('password') }}</strong> </span>
            @endif
            @if(isset($messages))
              <span style="color:#F44336;font-size:12px;"> <strong>{{ $messages[0] }}</strong> </span>
            @endif
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                </span>
                <div class="form-line">
                    {!!
                      Form::password('password',[
                        'class'=>'form-control',
                        'placeholder'=>trans('string.auth.password'),
                        'required'
                      ])
                    !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7 p-t-5">
                    <!-- <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-green-light-tosca">
                    {!! Form::label('rememberme', trans('string.auth.rememberme')) !!} -->
                </div>
                <div class="col-xs-5">
                    <button class="btn btn-block bg-green-light-tosca waves-effect" type="submit">{{ trans('string.auth.title') }}</button>
                </div>
                @if(null !== session('error') || isset($error))
                  <center>
                    <span style="color:#F44336;font-size:12px;"> <strong>{{ session('error') }}</strong> </span>
                  </center>
                @endif
            </div>

          {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
