@extends('layouts.login')

@section('content')
<section class="login-block">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="md-float-material form-material">
          <div class="text-center">
            <img src="https://omas-mfg.com/assets/images/logo.png" alt="logo.png">
          </div>
          <div class="auth-box card">
            <div class="card-block">
              <div class="row m-b-20">
                <div class="col-md-12">
                  <h3 class="text-center">Recover your password</h3>
                </div>
              </div>
              <div class="form-group form-primary">
                <input type="text" name="email-address" class="form-control" required="" placeholder="Your Email Address">
                <span class="form-bar"></span>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Reset
                    Password</button>
                </div>
              </div>
              <!-- <p class="f-w-600 text-right">Back to <a href="auth-normal-sign-in.html">Login.</a></p> -->
              <div class="row">
                <div class="col-md-10">
                  <p class="text-inverse text-left m-b-0">Thank you.</p>
                  <p class="text-inverse text-left">
                    <a href="{{ url('login') }}"><b class="f-w-600">Back to login</b></a>
                  </p>
                </div>
                <div class="col-md-2">
                  <img src="../files/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection