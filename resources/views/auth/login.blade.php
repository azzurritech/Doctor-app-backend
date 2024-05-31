@extends('layouts.app')

@section('content')


  <div class="hold-transition login-page" style="background-image:linear-gradient(rgba(0, 0, 255, 0.5), rgba(0, 0, 0, 0.5)), url('12.jpg');  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;">

        <div class="login-box" style="margin-top: -100px !important;">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center p-3">
                    <a href="/" class="h1"><b>Doc</b>live</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" name="password" required autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>

                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-primary">
                                <i class="mr-2"></i> Sign In
                            </button>
                        </div>
                    </form>

                    <p class="mb-1">
                    </p>
                    <p class="mb-0">
                    </p>
                </div>
            </div>
        </div>

    </div>
    

@endsection

