@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Смени студент</h6>
                </div>
              <div class="card-body">
                  {!! Form::open(['url' => 'admin/editCurrentUser/']) !!}
                      {{ Form::hidden('userId', $user->id) }}
                  <div class="form-group">
                      {{ Form::label('Име', null, ['class' => 'control-label']) }}
                      {{ Form::text('ime', $user->name, ['class' => 'form-control']) }}
                  </div>
                  <div class="form-group">
                      {{ Form::label('Презиме', null, ['class' => 'control-label']) }}
                      {{ Form::text('prezime', $user->surename, ['class' => 'form-control']) }}
                  </div>
                  <div class="form-group">
                    {{ Form::label('Смер', null, ['class' => 'control-label']) }}
                    {{ Form::label($user->smer->ime, null, ['class' => 'control-label badge badge-success']) }}
                    {{ Form::select('smer', [null => 'Избери смер'] + $smerovi, null, ['class' => 'form-control']) }}  
                  </div>
                     <div class="form-group">
                    {{ Form::label('Година', null, ['class' => 'control-label']) }}
                    {{ Form::label($user->year->name, null, ['class' => 'control-label badge badge-success']) }}
                    {{ Form::select('year', [null => 'Избери година'] + $godini, null, ['class' => 'form-control']) }}  
                  </div>
                  <div class="form-group">
                      {{ Form::label('Е-маил адреса', null, ['class' => 'control-label']) }}
                      {{ Form::text('email', $user->email, ['class' => 'form-control']) }}
                  </div>
                  <div class="form-group">
                      {{ Form::label('Лозинка', null, ['class' => 'control-label']) }}
                      {{ Form::password('password', ['class' => 'awesome', 'class' => 'form-control', 'placeholder' => 'Смени лозинка']) }}
                  </div>
              {{ Form::submit('Зачувај', ['class' => 'btn btn-primary btn-block']) }}
            {!! Form::close() !!}
                </div>
              </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection
