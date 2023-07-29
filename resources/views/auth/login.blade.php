@extends('layouts.login')

@section('content')
<section class="login-block">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form id="form-login" class="md-float-material form-material">
          <div class="text-center">
            <img src="https://omas-mfg.com/assets/images/logo.png" alt="logo.png">
          </div>
          <div class="auth-box card">
            <div class="card-block">
              <div class="row m-b-10">
                <div class="col-md-12">
                  <h3 class="text-center txt-primary">Sign In</h3>
                </div>
              </div>
              <div class="form-group form-primary">
                <input type="email" id="email" name="email" class="form-control" required="" placeholder="Email anda" value="nj.mudin18@gmail.com">
                <span class="form-bar"></span>
              </div>
              <div class="form-group form-primary">
                <input type="password" id="password" name="password" class="form-control" required="" placeholder="Password anda" value="123456789">
                <span class="form-bar"></span>
              </div>
              <div class="row m-t-10 text-left">
                <div class="col-12">
                  <div class="checkbox-fade fade-in-primary">
                    <label>
                      <input type="checkbox" value="">
                      <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                      <span class="text-inverse">Remember me</span>
                    </label>
                  </div>
                  <div class="forgot-phone text-right f-right">
                    <a href="{{ url('reset-password') }}" class="text-right f-w-600"> Lupa password?</a>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row m-t-10 text-center">
                <div class="col-md-12">
                  <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}" style="display: inline-block;"></div>
                </div>
              </div>
              <div class="row m-t-10">
                <div class="col-md-12">
                  <button type="submit" id="btn-login" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
                </div>
              </div>
              <p class="text-inverse text-left">Belum punya akun?
                <a href="{{ url('register') }}"><b class="f-w-600">Daftar disini</b>
                </a>
              </p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js-login')
<script>
  $(document).ready(function() {
    var token = '{{ csrf_token() }}';

    $(function() {
      $.validator.setDefaults({
        submitHandler: contact_action
      });
      $('#form-login').validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 5
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });

      function contact_action() {
        var captcha = grecaptcha.getResponse();
        // if (captcha == "" || captcha == null) {
        //   Swal.fire(
        //     'Oops...',
        //     'Silahkan cek dahulu captcha',
        //     'info'
        //   )
        // } else {
        $.ajax({
          type: 'POST',
          url: "{{ route('login') }}",
          data: {
            "email": $("#email").val(),
            "password": $("#password").val(),
            "g-recaptcha-response": grecaptcha.getResponse(),
            "_token": token
          },
          beforeSend: function() {
            $("#error").fadeOut();
            $("#btn-login").prop('disabled', true);
            $("#btn-login").html('Proses Login <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
          },
          success: function(response) {
            // var data = JSON.parse(response);
            // console.log(data);
            // if (data.status == 'ok') {
            //   Swal.fire(
            //     'Sukses',
            //     'Pesan anda sudah terkirim',
            //     'success'
            //   )
            // } else {
            //   Swal.fire(
            //     'Oops...',
            //     'test',
            //     'info'
            //   )
            // }

            var home = "{{ route('home') }}";

            setTimeout('window.location.href = "' + home + '";', 1000);

            grecaptcha.reset();
            $("#btn-login").prop('disabled', false);
            $("#btn-login").html('Login');
          },
          error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status = 422) {
              Swal.fire(
                'Oops...',
                jqXHR.responseJSON.errors.email[0],
                textStatus
              );
            }
            $("#btn-login").prop('disabled', false);
            $("#btn-login").html('Login');
            grecaptcha.reset();
          }
        });
        //}
        return false;
      }

      var width = $('.g-recaptcha').parent().width();
      console.log(width);
      if (width < 302) {
        var scale = width / 302;
        $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
        $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
        $('.g-recaptcha').css('transform-origin', '0 0');
        $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
      }
    });
  });
</script>
@endsection