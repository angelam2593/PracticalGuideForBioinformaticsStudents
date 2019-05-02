@extends('layouts.app_login')

@section('content')
<body class="bg-gradient-primary">
    <div class="container center-div">
    <div class="row" style="width:800px; margin:0 auto;">
        <div class="col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body">
                    <h1 class="h4 text-gray-900 mb-2 text-center">Регистрирај се</h1>
                    <form method="POST" action="{{ route('register') }}" class="user" style="margin-top: 30px;">
                        @csrf
                        <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} form-control-user" name="name" value="{{ old('name') }}" placeholder="Име" required autofocus>
                                        @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                </div>
                            
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="surename" type="surename" class="form-control{{ $errors->has('surename') ? ' is-invalid' : '' }} form-control-user" name="surename" value="{{ old('surename') }}" placeholder="Презиме" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surename') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>
                         <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input id="indeks" type="text" class="form-control{{ $errors->has('indeks') ? ' is-invalid' : '' }} form-control-user" name="indeks" value="{{ old('indeks') }}" placeholder="Индекс" required autofocus>
                                        @if ($errors->has('indeks'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('indeks') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>
                         <div class="form-group row">
                                <div class="col-sm-6">
                                    <h6>Избери година/семестар</h6>
                                    <select id="year" name="year" placeholder="Година" required class="form-control-user btn-block" autofocus>
                                        @foreach($godini as $godina)
                                         <option value="{{ $godina }}">{{ $godina }}</option>
                                        @endforeach
                                    </select>

                                @if ($errors->has('year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <h6>Избери смер</h6>
                                    <select id="smer" name="smer" placeholder="Смер" required class="}} form-control-user btn-block" autofocus>
                                        @foreach($smerovi as $smer)
                                         <option value="{{ $smer }}">{{ $smer }}</option>
                                        @endforeach
                                    </select>

                                @if ($errors->has('smer'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('smer') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                       <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-user" name="password" placeholder="Лозинка" required>
                                    
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                </div>
                            
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                       <input id="password" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}  form-control-user" name="password_confirmation" placeholder="Потврди лозинка" required>

                                
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <b>{{ __('Регистрирај се') }}</b>
                                </button>
                            </div>
                        </div>
                    <hr>
                    <div class="form-group row mb-0">
                            <div class="col-md-12  text-center">
                              @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-user" href="{{ route('password.request') }}">
                                        <b>{{ __('Ја заборави лозинката?') }}</b>
                                    </a><br>
                                    <a class="btn btn-link btn-user" href="{{ route('login') }}" style="margin-top: -20px;">
                                        <b>{{ __('Логирај се') }}</b>
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
</body>
@endsection