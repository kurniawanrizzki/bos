$(function () {
    var validation = {
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
          if (($(element).parents('.form-group')).length > 0) {
            $(element).parents('.form-group').append(error);
            return;
          }
          $(element).parents('.input-group').append(error);
        }
    };
    $('#sign_in').validate(validation);
    $('#item-form').validate(validation);
    $('#profile-form').validate(validation);
});
