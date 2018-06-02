@extends('layouts.app')
@section('title')
    @parent
    {{ $errorCode }}
@endsection

@section('content')
<div class="four-zero-four-container">
    <div class="error-code">{{ $errorCode }}</div>
    <div class="error-message">{{ $explanation }}</div>
    <div class="button-place">
        <a href="/" class="btn btn-default btn-lg waves-effect">{{ trans('string.goback') }}</a>
    </div>
</div>
@endsection
