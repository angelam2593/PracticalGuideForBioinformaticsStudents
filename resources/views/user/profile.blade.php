@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold">Ваш кориснички профил</h6>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['url' => 'user/edit_profile/']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('Име', null, ['class' => 'control-label']) }}
                                        {{ Form::text('ime', $logged_user->name, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Презиме', null, ['class' => 'control-label']) }}
                                        {{ Form::text('prezime', $logged_user->surename, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Е-маил адреса', null, ['class' => 'control-label']) }}
                                        {{ Form::text('email', $logged_user->email, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Лозинка', null, ['class' => 'control-label']) }}
                                        {{ Form::text('lozinka', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('Индекс', null, ['class' => 'control-label']) }}
                                        {{ Form::text('indeks', $logged_user->userid, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Година на слушање', null, ['class' => 'control-label']) }}
                                        {{ Form::label($logged_user->year->name, null, ['class' => 'control-label badge badge-success']) }}  
                                        {{ Form::select('year', [null => 'Смени година'] + $godini , null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('Смер', null, ['class' => 'control-label']) }}
                                        {{ Form::label($logged_user->smer->ime, null, ['class' => 'control-label badge badge-success']) }}  
                                        {{ Form::select('smer', [null => 'Смени смер'] + $smerovi , null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group" style="margin-top: 47px;">
                                        {{ Form::submit('Зачувај', ['class' => 'btn btn-primary btn-block']) }}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                  </div>
                </div>
        </div>
</div>
@endsection
