@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<ol>
    			@foreach($zadaci as $zadaca)
                <li><h4>{{ $zadaca->title }} &nbsp;<a class="btn btn-primary" href="{{ URL::route('admin_exercises_overview', ['id' => $zadaca->id]) }}">Разгледај</a></li></h4>
                @endforeach
    		</ol>
    	</div>
    </div>
</div>
@endsection
