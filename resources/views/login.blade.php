@extends('layouts.partial')
<body class="hold-transition login-page">
<div class="login-box ">
  <div class="d-flex justify-content-center">
    <div class="login-logo">
      <img src="@image('/logo.png')" alt="Image" width="70" height="70">
            <a><b>UFI </b>Helpdesk</a>
    </div>
  </div>
  <!-- /.login-logo -->
  <div class="card rounded-4">
    <div class="card-body login-card-body">
      <p class="login-box-msg">IT Helpdesk</p>

      <form method="POST" action="{{ route('login') }}">
      @csrf
        <div class="input-group mb-3">
        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="username">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
          </div>
          @if (Route::has('register'))
            <div class="col-4">
             <a class="btn btn-primary btn-block" href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
          @endif
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-3">
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE')}}/dist/js/adminlte.min.js"></script>
</body>
</html>
