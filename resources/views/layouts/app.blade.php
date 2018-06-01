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
    <link href="{{ asset('/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/themes/all-themes.css') }}" rel="stylesheet" />
  </head>
  <body class="{{ !starts_with(Route::currentRouteName(),'auth')?'theme-red':'login-page' }}">
    @yield('content')
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/plugins/node-waves/waves.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-spinner/js/jquery.spinner.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/assets/js/simple.money.format.js') }}"></script>
    <script src="{{ asset('/assets/js/admin.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/examples/sign-in.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {

      $("input[name='item_price']").simpleMoneyFormat();
      $("input[name='item_price']").on('change blur',function(){
        if($(this).val().trim().length === 0){
          $(this).val('1,000');
        }
      });

      $('#delete_confirmation_modal').on('show.bs.modal', function(e) {
          var url = null;
          var dataId = $(e.relatedTarget).data('product-id');
          var dataName = $(e.relatedTarget).data('product-name');

          if ('undefined' !== typeof(dataId) && 'undefined' !== typeof(dataName)) {
            url = '/dashboard/item/'+dataId+'/delete';
          } else {
            dataId = $(e.relatedTarget).data('transaction-id');
            dataName = $(e.relatedTarget).data('transaction-number');

            if ('undefined' === typeof(dataId) && 'undefined' === typeof(dataName)) {
              return;
            }
            url = '/dashboard/transaction/'+dataId+'/delete';
          }

          var title = 'Do you want to delete this <strong> '+dataName+' </strong> data?';

          $('#delete_confirmation_modal_content').html(title);
          $('#delete_confirmation_modal_confirm').attr('href',url);
      });

      $('#status_update_confirmation_modal').on('show.bs.modal', function(e){
        var dataId = $(e.relatedTarget).data('transaction-id');
        var dataName = $(e.relatedTarget).data('transaction-number');
        var dataValue = $(e.relatedTarget).data('transaction-value');
        var dataAttr = $(e.relatedTarget).data('transaction-attribute');
        var descAttr = (dataAttr == 0)?"cancel":((dataAttr == 1)?"transfer":"deliver");
        var content = "Do you want to update the "+descAttr+" status of <strong> "+dataName+" </strong> data?";

        if (dataAttr > 1 && dataValue < 1) {
          content = 'Please to fill this field before update '+descAttr+' status of <strong>'+dataName+" </strong> : "+
                    '<br><span style="color:#F44336;font-size:12px;" id="invoice_required" hidden> <strong> Please to fill the invoice number before confirm it. </strong> </span>'+
                    '<div class="form-group form-float">'+
                        '<div class="form-line">'+
                            '{!! Form::text("item_invoice","",["class"=>"form-control","placeholder"=>"INVOICE NUMBER"]) !!}'+
                        '</div>'+
                    '</div>';
        }


        $('#status_update_confirmation_modal_content').html(content);
        $('#status_update_confirmation_modal_confirm').attr('data-transaction-id',dataId);
        $('#status_update_confirmation_modal_confirm').attr('data-transaction-attribute',dataAttr);

      });

      $(document).on('click','#status_update_confirmation_modal_confirm', function(e) {
        var dataId = $(this).data('transaction-id');
        var dataAttr = $(this).data('transaction-attribute');
        var dataInvoice = '';

        if (dataAttr > 1) {
          dataInvoice = $("input[name='item_invoice']").val();
        }

        $.ajax({
          type    : 'POST',
          url     : "{{ route('api.transaction.update') }}",
          dataType: 'json',
          data    : { token:"{{ \Session::get('token') }}", id:dataId, type:dataAttr, invoice:dataInvoice},
          success : function(e) {
            if (e.updated) {
              location.reload();
              return;
            }
            if (dataAttr > 1) {
              $('#invoice_required').show();
            }
          },
          error   : function(e) {
            console.log(e);
            $('#status_update_confirmation_modal').modal('hide');
          }
        });
      })

      $('#transactions_tb').DataTable({
        responsive : true,
        processing : true,
        serverSide : true,
        ajax       : {
          type     : 'POST',
          url      : "{{ route('api.transactions') }}",
          dataType : 'json',
          data    : { token:"{{ \Session::get('token') }}"},
        },
        columns    : [
          {'data':'TRANSACTION_NUMBER'},
          {'data':'INVOICE_NUMBER'},
          {'data':'TRANSACTION_DATE'},
          {'data':'CUSTOMER_NAME','name':'CLIENT.CLIENT_NAME'},
          {'data':'IS_CANCELED'},
          {'data':'IS_TRANSFERED'},
          {'data':'IS_DELIVERED'},
        ]
      });

      $('#items_tb').DataTable({
        responsive : true,
        processing : true,
        serverSide : true,
        ajax       : {
          type     : 'POST',
          url      : "{{ route('api.items') }}",
          dataType : 'json',
          data     : { token:"{{ \Session::get('token') }}"},
        },
        columns    : [
          {'data':'ITEM_CODE'},
          {'data':'ITEM_NAME'},
          {'data':'ITEM_SIZE'},
          {'data':'ITEM_STOCK'},
          {'data':'PRICE'},
          // {'data':'ACTION','searchable':false,'orderable':false}
        ]
      });

    });
    </script>
  </body>
</html>
