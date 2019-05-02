@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
           <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Едитувај тема</h6>
                  </div>
                  <div class="card-body">
                    {!! Form::open(['url' => 'admin/editTheme']) !!}
                    <div class="form-group">
                        {{ Form::label('Име', null, ['class' => 'control-label']) }}
                        {{ Form::text('ime', $tema->title, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group"> 
                        <a href="#">{{ Form::label('Линк за предавање', null, ['class' => 'control-label']) }}</a>
                        {{ Form::text('predavanje_link', $tema->predavanje_link, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <a href="#">{{ Form::label('Линк за аудиториски вежби', null, ['class' => 'control-label']) }}</a>
                        {{ Form::text('auditoriski_link', $tema->auditoriski_link, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                      {{ Form::label('Дата на почеток', null, ['class' => 'control-label']) }}
                      {{ Form::label('Stavi data', $tema->data_pocetok, ['class' => 'control-label badge badge-success']) }}
                      {{ Form::text('data_pocetok', null, array_merge(['class' => 'form-control', 'id' => 'date'])) }}
                    </div>
                    <div class="form-group">
                      {{ Form::label('Дата на крај', null, ['class' => 'control-label']) }}
                      {{ Form::label('Stavi data', $tema->data_kraj, ['class' => 'control-label badge badge-success']) }}
                      {{ Form::text('data_kraj', null, array_merge(['class' => 'form-control', 'id' => 'date1'])) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Опис на темата', ['class' => 'control-label']) !!}
                        {!! Form::textarea('description', $tema->description ,['class' => 'form-control', 'placeholder' => 'Insert description', 'id' => 'summernote']) !!}
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
