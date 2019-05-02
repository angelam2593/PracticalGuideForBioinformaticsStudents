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
		        </div
		    @elseif (\Session::has('error'))
		        <div class="alert alert-success">
		            <ul>
		                <li>{!! \Session::get('error') !!}</li>
		            </ul>
		        </div>
		    @endif
         	<div class="row">
         		<div class="col-md-6">
         			<div class="card shadow mb-4">
		            <div class="card-header py-3">
		              <h6 class="m-0 font-weight-bold">Ваш кориснички профил</h6>
		            </div>
		            <div class="card-body">
		            	{!! Form::open(['url' => 'admin/edit_user_profile/']) !!}
							<div class="form-group">
							    {{ Form::label('Име', null, ['class' => 'control-label']) }}
							    {{ Form::text('ime', $logged_user->name, ['class' => 'form-control']) }}
							</div>
							<div class="form-group">
							    {{ Form::label('Презиме', null, ['class' => 'control-label']) }}
							    {{ Form::text('prezime', $logged_user->surename, ['class' => 'form-control']) }}
							</div>
							<div class="form-group">
								{{ Form::label('Позиција', null, ['class' => 'control-label']) }}
								{{ Form::label($logged_user->position->title, null, ['class' => 'control-label badge badge-success']) }}
								{{ Form::select('position', [null => 'Смени позиција'] + $pozicii, null, ['class' => 'form-control']) }}	
							</div>
							<div class="form-group">
							    {{ Form::label('Е-маил адреса', null, ['class' => 'control-label']) }}
							    {{ Form::text('email', $logged_user->email, ['class' => 'form-control']) }}
							</div>
							<div class="form-group">
							    {{ Form::label('Лозинка', null, ['class' => 'control-label']) }}
							    {{ Form::password('password', ['class' => 'awesome', 'class' => 'form-control', 'placeholder' => 'Смени лозинка']) }}
							</div>
							{{ Form::submit('Зачувај', ['class' => 'btn btn-primary btn-block', 'onClick' => 'saveProfile(this)']) }}
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
