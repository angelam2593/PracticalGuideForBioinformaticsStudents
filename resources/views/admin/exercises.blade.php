@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Задачи</h6>
            </div>
            <div class="card-body">
              <div class="dropdown mb-4">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Избери тема
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ URL::route('show_tema', ['id' => 0]) }}">Сите теми</a>
                    @foreach($temi as $tema)
                      <a class="dropdown-item" href="{{ URL::route('show_tema', ['id' => $tema->id]) }}">{{ $tema->title }}</a>
                    @endforeach
                </div>
                <a class="btn btn-primary" href="{{ URL::route('add_exercise') }}">Додади задача</a>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Тема</th>
                      <th>Опис</th>
                      <th>Дата на почеток</th>
                      <th>Дата на крај</th>
                      <th>Акција</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($zadaci as $zadaca)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $zadaca->title }}</td>
                        <td>{{ $zadaca->theme->title }}</td>
                        <td>{!! $zadaca->description !!}</td>
                        <td>{{ $zadaca->theme->data_pocetok }}</td>
                        <td>{{ $zadaca->theme->data_kraj }}</td>
                        <td><a class="btn btn-info" href="{{ URL::route('exercise_edit', ['id' => $zadaca->id]) }}">Измени</a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
