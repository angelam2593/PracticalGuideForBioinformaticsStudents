@extends('layouts.app_login')

@section('content')
<body class="bg-gradient-primary">
  <div class="container center-div">
    <div class="row" style="width:600px; margin:0 auto;">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                <div class="card-body">
                    <h1 class="h4 text-gray-900 mb-2 text-center">Логирај се</h1>
                    <form method="POST" action="{{ route('login') }}" class="user">
                        @csrf
                        <div class="form-group row" style="margin-top: 30px;">
                            <!--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>-->
                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" required autofocus style="text-align:center;">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <!--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->

                            <div class="col-md-8 offset-md-2">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-user" name="password" required style="text-align:center;">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <div class="form-check">
                                     <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" {{ old('remember') ? 'checked' : '' }} name="remember" id="remember" >
                                        <label class="custom-control-label" for="customCheck"><b>Запамти ме</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <b>{{ __('Логирај се') }}</b>
                                </button>
                            </div>
                            <div class="col-md-12  text-center">
                              @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-user" href="{{ route('password.request') }}">
                                        <b>{{ __('Ја заборави лозинката?') }}</b>
                                    </a><br>
                                    <a class="btn btn-link btn-user" href="{{ route('register') }}" style="margin-top: -20px;">
                                        <b>{{ __('Регистрирај се') }}</b>
                                    </a>
                                @endif
                            </div>
                            
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
