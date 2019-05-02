@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
          {!! Form::open(['url' => '/admin/addTheme', 'files' => 'true', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
              {!! Form::label('title', 'Add theme name') !!}
                <div class="col-sm-10">
                  {!! Form::textarea('title', null, ['class' => 'form-control', 'placeholder' => 'Add your project name', 'rows' => 2]) !!}
                </div>
            </div> <div class="form-group">
                        {!! Form::label('description', 'Description of the task *', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', '',['class' => 'form-control', 'placeholder' => 'Insert description', 'rows' => 10, 'id' => 'description']) !!}
                        </div>
                    </div>
                <div class="col-sm-12">
                   <div class="form-group">
                        {!! Form::label('deadline', 'Дата на почеток*', ['class' => 'control-label']) !!}
                        <div class="input-group col-sm-5" style="padding-left: 15px">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div> &nbsp;
                            {!! Form::text('deadline', null, ['class' => 'form-control', 'id' => 'date']) !!}
                        </div>
                    </div>
                </div>
                  <div class="col-sm-12">
                   <div class="form-group">
                        {!! Form::label('deadline', 'Дата на крај*', ['class' => 'control-label']) !!}
                        <div class="input-group col-sm-5" style="padding-left: 15px">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div> &nbsp;
                            {!! Form::text('deadline', null, ['class' => 'form-control', 'id' => 'date']) !!}
                        </div>
                    </div>
                </div>
           {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
