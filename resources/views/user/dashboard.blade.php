@extends('layouts.app')

@section('content')
  <div class="container">
   <div class="row" style="margin-top: 10px;">
        @foreach($temi as $tema)
        <div class="col-md-4 text-center">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-weight: bold;">{{ $tema->title }}</h4>
                    <a href="{{ $tema->predavanje_link }}">Предавање</a><br>
                    <a href="{{ $tema->auditoriski_link }}">Аудиториски вежби</a>
                </div>
                <div class="card-body">
                    <p>
                        {{ $tema->body }}
                    </p>                                      
                    <a class="btn btn-default btn-success" href="{{ URL::route('user_themes', ['id' => $tema->id]) }}">Влези<div class="glyphicon glyphicon-circle-arrow-right"></div></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
@endsection
