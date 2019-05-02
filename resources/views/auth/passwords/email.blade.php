@extends('layouts.app_login')

@section('content')
<body class="bg-gradient-primary">
  <div class="container center-div">
    <div class="row" style="width:600px; margin:0 auto;">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="user">
                        @csrf
                     <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Заборави лозинка?</h1>
                    <p class="mb-4">Внеси ја е-маил адресата и ќе ти пратиме маил за промена на лозика.</p>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </div>
                     <button type="submit" class="btn btn-primary btn-user btn-block">
                        <b>{{ __('Ресетирај лозинка') }}</b>
                      </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ URL::route('register') }}"><b>Регистрирај се</b></a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{ URL::route('login') }}"><b>Веќе имаш корисник? Логирај се</b></a>
                  </div>
                </div>
              </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection

