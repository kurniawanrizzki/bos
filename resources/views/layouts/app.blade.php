<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
      {{ env('APP_NAME') }}
      @section('title')
          -
      @show
    </title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/themes/all-themes.css') }}" rel="stylesheet" />
  </head>
  <body class="theme-green">
    @yield('content')
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/plugins/node-waves/waves.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/js/admin.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/examples/sign-in.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('ul.bos-status-dropdown li').click(function(e) {
        var status = $(this).text();

        $.ajax({
            type    :'POST',
            url     : "{{ route('transaction.update') }}",
            data    : { _token:$('#token').val(),updated:status,id:$('#transaction_id').val() },
            dataType: 'json',
            success : function (e) {

              console.log(e);
              var bosElement = $('#bos-status');

              var deliveredStatus = "{{ trans('string.delivered_status') }}";
              var canceledStatus = "{{ trans('string.canceled_status') }}";
              var transferedStatus = "{{ trans('string.transfered_status') }}";

              bosElement.text(status);
              bosElement.removeAttr('class');

              if (status == deliveredStatus ) {
                bosElement.attr('class','btn btn-success waves-effect dropdown-toggle');
                bosElement.attr('disabled',true);
              } else if (status == transferedStatus) {
                bosElement.attr('class','btn btn-primary waves-effect dropdown-toggle');
              } else if (status == canceledStatus) {
                bosElement.attr('class','btn btn-danger waves-effect dropdown-toggle');
                bosElement.attr('disabled',true);
              }

            },
            error   : function (e) {
                console.log(e);
            }
        });

      });
    });
    </script>
  </body>
</html>
