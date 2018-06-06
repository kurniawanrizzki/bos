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
    <link rel="stylesheet" href="{{'/assets/plugins/font-awesome/css/font-awesome.css'}}">
    <link href="{{ asset('/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/jquery-contextmenu/jquery.contextMenu.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/themes/all-themes.css') }}" rel="stylesheet" />
  </head>
  <body class="{{ starts_with(Route::currentRouteName(),'auth')?'login-page':(starts_with(Route::currentRouteName(),'error')?'four-zero-four':'theme-red') }}">
    @yield('content')
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/plugins/node-waves/waves.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-contextmenu/jquery.contextMenu.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-spinner/js/jquery.spinner.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/js/simple.money.format.js') }}"></script>
    <script src="{{ asset('/assets/js/admin.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/examples/sign-in.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {

      var isContextInitated = false;

      $("input[name='item_price']").simpleMoneyFormat();
      $("input[name='item_price']").on('change blur',function(){
        if($(this).val().trim().length === 0){
          $(this).val('1,000');
        }
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
        select     : true,
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
        ],
        rowId : 'TRANSACTION_ID',
        "dom": 'l<"H"Rf>t<"F"ip>'
      });

      $.contextMenu({
        selector : "#transactions_tb tr",
        callback : function (key, options) {
          var row = $('#transactions_tb').DataTable().row($(this).index());
          var transactionId = row.id();
          var transactionNumber = row.data().TRANSACTION_NUMBER;
          switch (key) {
            case "view":
              window.location.href = "/dashboard/transaction/"+transactionId+"/view";
              break;
            case "print":
              window.location.href = "/dashboard/transaction/"+transactionId+"/print";
              break;
            case "remove":
              setDeleteModalContent(transactionId, transactionNumber, "transaction");
              $('#delete_confirmation_modal').modal('show');
              break;
            default:
              var text = options.$selected.find('span').text();
              if ((text == "TRANSACTION NUMBER") || (text == "INVOICE NUMBER") || (text == "DATE") || (text == "CUSTOMER NAME") || (text == "C") || (text == "T") || (text == "D")) {
                if ($(options.$selected).find("i").length > 0) {
                  $(options.$selected).find("i").remove();
                  $(options.$selected).find('span').html(text);
                  $('#transactions_tb').DataTable().column(getTransactionColumnIndex(text)).visible(false);
                  return;
                }
                $(options.$selected).append("<i class='fa fa-check' style='float:right'></i>");
                $('#transactions_tb').DataTable().column(getTransactionColumnIndex(text)).visible(true);
              }
              break;
          }
        },
        items    : {
          view  : {name:"View",icon:"fa-search"},
          print : {name:"Print", icon:"fa-print"},
          remove: {name:"Delete", icon:"fa-trash"},
          separator : "-",
          tools : {name:"Show / Hide Column", icon:"fa-columns", items:{
              transactionNumber  :{name:"TRANSACTION NUMBER",icon:"fa-file-o"},
              invoiceNumber      :{name:"INVOICE NUMBER", icon:"fa-file-o"},
              date               :{name:"DATE",icon:"fa-file-o"},
              client             :{name:"CUSTOMER NAME",icon:"fa-file-o"},
              status             :{name:"STATUS",icon:"fa-files-o",items:{
                  canceled       :{name:"C",icon:"fa-file-o"},
                  transfered     :{name:"T",icon:"fa-file-o"},
                  delivered      :{name:"D",icon:"fa-file-o"},
                }
              }
            }
          }
        },
        events:{
          show: function (options) {

            if (!isContextInitated) {
              options.$menu.find('li').each(function(){
                var text = $(this).find('span').text();
                var subList = $(this).find('ul');

                if (subList.length > 0) {
                  subList.find('li').each(function(){
                    var text = $(this).find('span').text();
                    if ((text == "C") || (text == "T") || (text == "D")) {
                      if ($(this).find("i").length == 0) {
                        $(this).append("<i class='fa fa-check' style='float:right'></i>");
                      }
                    }
                  });
                }

                if ((text == "TRANSACTION NUMBER") || (text == "INVOICE NUMBER") || (text == "DATE") || (text == "CUSTOMER NAME")) {
                    $(this).append("<i class='fa fa-check' style='float:right'></i>");
                }

              });
              isContextInitated = !isContextInitated;
            }

          }
        }
      });

      $('.filter-btn').on('click', function(){
        var cmd = $(this).text();
        var isClicked = $(this).hasClass('bg-blue-grey');
        switch (cmd) {
          case "CANCELED":
            buttonGroupEvent(this, isClicked, 'btn-info','bg-blue-grey');
            break;
          case "TRANSFERED":
            buttonGroupEvent(this, isClicked, 'btn-info','bg-blue-grey');
            break;
          case "DELIVERED":
            buttonGroupEvent(this, isClicked, 'btn-info','bg-blue-grey');
            break;
          default:
            buttonGroupEvent(this, isClicked,'bg-blue-grey','btn-info');
            $('.filter-btn').each(function(){
              var text = $(this).text();
              if (text != "ALL") {
                $(this).removeClass('bg-blue-grey');
                $(this).addClass('btn-info');
              }
            });
            break;

        }
        searchByStatus();
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
          {'data':'PRICE'}
        ],
        rowId : 'ITEM_ID',
        "dom": 'l<"H"Rf>t<"F"ip>'
      });

      $.contextMenu({
        selector : "#items_tb tr",
        callback : function (key, options) {
          var row = $('#items_tb').DataTable().row($(this).index());
          var itemId = row.id();
          var itemDesc = row.data().ITEM_CODE+" - "+row.data().ITEM_NAME;
          switch (key) {
            case "view":
              window.location.href = "/dashboard/item/"+itemId+"/view";
              break;
            case "edit":
              window.location.href = "/dashboard/item/form/"+itemId;
              break;
            case "remove":
              setDeleteModalContent(itemId, itemDesc, "item");
              $('#delete_confirmation_modal').modal('show');
              break;
            default:
              break;
          }
        },
        items    : {
          view  : {name:"View",icon:"fa-search"},
          edit : {name:"Edit", icon:"fa-pencil"},
          remove: {name:"Delete", icon:"fa-trash"}
        }
      });

      function setDeleteModalContent (dataId, dataName, dataType) {
        var url = null;

        if ("item" == dataType) {
          url = '/dashboard/item/'+dataId+'/delete';
        } else if ("transaction" == dataType) {
          url = '/dashboard/transaction/'+dataId+'/delete';
        }

        var title = 'Do you want to delete this <strong> '+dataName+' </strong> data?';

        $('#delete_confirmation_modal_content').html(title);
        $('#delete_confirmation_modal_confirm').attr('href',url);
      }

      function getTransactionColumnIndex (index) {
        switch (index) {
          case "TRANSACTION NUMBER" :
            return 0;
          case "INVOICE NUMBER" :
            return 1;
          case "DATE" :
            return 2;
          case "CUSTOMER NAME" :
            return 3;
          case "C" :
            return 4;
          case "T" :
            return 5;
          case "D" :
            return 6;
          default:
            return -1;
        }
      }

      function buttonGroupEvent (component, isClicked, defaultColor, clickedColor) {
        if (isClicked) {
          $(component).removeClass(clickedColor);
          $(component).addClass(defaultColor);
          return;
        }
        $(component).removeClass(defaultColor);
        $(component).addClass(clickedColor);

        var allButton = $('.filter-btn')[0];
        if ($(allButton).hasClass(clickedColor)) {
          $(allButton).removeClass(clickedColor);
          $(allButton).addClass(defaultColor);
        }
      }

      function searchByStatus () {

        var allButton = $('.filter-btn')[0];
        var columnIndex = 3;
        var dTable = $('#transactions_tb').DataTable();

        if (!$(allButton).hasClass('bg-blue-grey')) {
          $('.filter-btn').each(function(){
            var cmd = $(this).text();

            if ($(this).hasClass('bg-blue-grey')) {
              dTable.column(columnIndex).search(1);
            } else {
              if (cmd != 'ALL') {
                dTable.column(columnIndex).search(0);
              }
            }
            columnIndex++;

          });
          dTable.draw();
          return;
        }
        dTable.search( '' ).columns().search( '' ).draw();
      }

    });
    </script>
  </body>
</html>
