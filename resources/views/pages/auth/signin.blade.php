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
            'id' => 'signin_page'
            ])
          !!}

            <div class="msg">{{ trans('string.auth.welcome') }}</div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                    {!!
                      Form::text('username', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('string.auth.username'),
                        'required autofocus'
                      ])
                    !!}
                </div>
            </div>
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
                <div class="col-xs-8 p-t-5">
                    <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-green-light-tosca">
                    {!! Form::label('rememberme', trans('string.auth.rememberme')) !!}
                </div>
                <div class="col-xs-4">
                    <button class="btn btn-block bg-green-light-tosca waves-effect" type="submit">{{ trans('string.auth.title') }}</button>
                </div>
            </div>

          {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
