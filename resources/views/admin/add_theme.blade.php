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
                    <h6 class="m-0 font-weight-bold">Додади тема</h6>
                  </div>
                  <div class="card-body">
                    {!! Form::open(['url' => 'admin/addStudent']) !!}
                    <div class="form-group">
                        {{ Form::label('Име', null, ['class' => 'control-label']) }}
                        {{ Form::text('ime', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group"> 
                        {{ Form::label('Линк за предавање', null, ['class' => 'control-label']) }}
                        {{ Form::text('predavanje_link', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group"> 
                        {{ Form::label('Линк за аудиториски вежби', null, ['class' => 'control-label']) }}
                        {{ Form::text('auditoriski_link', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                      {{ Form::label('Година', null, ['class' => 'control-label']) }}
                      {{ Form::select('smer', [null => 'Избери година'] + $godini, null, ['class' => 'form-control']) }}  
                    </div>
                    <div class="form-group">
                      {{ Form::label('Дата на почеток', null, ['class' => 'control-label']) }}
                      {{ Form::text('data_pocetok', null, array_merge(['class' => 'form-control', 'id' => 'date'])) }}
                    </div>
                    <div class="form-group">
                      {{ Form::label('Дата на крај', null, ['class' => 'control-label']) }}
                      {{ Form::text('data_kraj', null, array_merge(['class' => 'form-control', 'id' => 'date1'])) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Опис на темата', ['class' => 'control-label']) !!}
                        {!! Form::textarea('description', '',['class' => 'form-control', 'placeholder' => 'Insert description', 'id' => 'summernote']) !!}
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
