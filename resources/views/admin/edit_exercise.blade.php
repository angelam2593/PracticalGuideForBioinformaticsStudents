@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
          @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
          @endif
            <div class="row">
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Смени задача</h6>
                </div>
              <div class="card-body">
                  {!! Form::open(['url' => 'admin/addNewExercise']) !!}
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          {{ Form::label('Име', null, ['class' => 'control-label']) }}
                          {{ Form::text('ime', $zadaca->title, ['class' => 'form-control']) }}
                      </div>
                      <div class="form-group">
                        {{ Form::label('Тема', null, ['class' => 'control-label']) }}
                        {{ Form::select('theme', [null => 'Избери тема'] + $temi, null, ['class' => 'form-control']) }}  
                      </div>
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#opis" role="tab" aria-controls="home" aria-selected="truex"><b>Опис</b></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#input" role="tab" aria-controls="profile" aria-selected="false"><b>Тест Input</b></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#output" role="tab" aria-controls="profile" aria-selected="false"><b>Тест Output</b></a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="opis" role="tabpanel" aria-labelledby="home-tab">
                          <br>
                          <div class="form-group">
                            {!! Form::textarea('description', '',['class' => 'form-control', 'placeholder' => 'Insert description', 'id' => 'summernote']) !!}
                          </div>
                        </div>
                        <div class="tab-pane fade" id="input" role="tabpanel" aria-labelledby="profile-tab">
                          <br>
                          <div class="form-group">
                            {!! Form::textarea('description_input', '',['class' => 'form-control', 'placeholder' => 'Insert description', 'id' => 'description_input']) !!}
                          </div>
                        </div>
                        <div class="tab-pane fade" id="output" role="tabpanel" aria-labelledby="contact-tab">
                          <br>
                          <div class="form-group">
                            {!! Form::textarea('description_output', '',['class' => 'form-control', 'placeholder' => 'Insert description', 'id' => 'description_output']) !!}
                          </div>
                        </div>
                      </div>
                    </div>
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
