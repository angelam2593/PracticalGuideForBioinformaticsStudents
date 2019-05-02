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
                      <h6 class="m-0 font-weight-bold">{{ $student->name }} {{ $student->surename}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ol>
                                    @foreach($temi as $tema)
                                        <li>{{ $tema->title }}</li>
                                        @foreach($reseni_zadaci as $resena_zadaca)
                                            <ul>
                                            @if($resena_zadaca->theme_id == $tema->id)
                                                <li>{{ $resena_zadaca->ime_zadaca($resena_zadaca->id)['title'] }} <span class="badge badge-success">{{ $resena_zadaca->points }}</span></li>
                                            @endif
                                            </ul>
                                        @endforeach
                                    @endforeach
                                </ol>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                  <h5>Статус на положеност:</h5>
                                  @if($student->polozenost == 1)
                                      <span class="badge badge-success">Положен</span>
                                  @elseif($student->polozenost == NULL)
                                      <span class="badge badge-warning">Го слуша предметот</span>
                                  @else
                                      <span class="badge badge-danger">Не е положен</span>
                                  @endif
                                </div>
                                <br>
                                <div class="row">
                                  <h5>Поени од вежби:</h5>
                                  <span class="badge badge-warning"></span>
                                </div>
                                <br>
                                <div class="row">
                                  <h5>Оценка:</h5>
                                  <span class="badge badge-warning"></span>
                                </div>
                            </div>  
                        </div>
                    </div>
                  </div>
                </div>
        </div>
</div>
      </div>
    </div>
  </div>
@endsection
