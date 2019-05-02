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
              <h6 class="m-0 font-weight-bold text-primary">Студенти</h6>
            </div>
            <div class="card-body">
             <div class="dropdown mb-4">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Избери година
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ URL::route('show_godini', ['id' => 0]) }}">Сите години</a>
                    @foreach($godini as $godina)
                      <a class="dropdown-item" href="{{ URL::route('show_godini', ['id' => $godina->id]) }}">{{ $godina->name }}</a>
                    @endforeach
                </div>
                <a class="btn btn-primary" href="{{ URL::route('add_student') }}">Додади студент</a>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Презиме</th>
                      <th>Индекс</th>
                      <th>Смер</th>
                      <th>Семестар</th>
                      <th>Дата на креирање</th>
                      <th>Измени</th>
                      <th>Профил</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($studenti as $student)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $student->name }}</td>
                      <td>{{ $student->surename }}</td>
                      <td>{{ $student->userid }}</td>
                      <td>{{ $student->smer->ime }}</td>
                      <td>{{ $student->year->name }}</td>
                      <td>{{ $student->created_at }}</td>
                      <td><a class="btn btn-primary" href="{{ URL::route('user_edit', ['id' => $student->id]) }}">Измени</a></td>
                      <td><a class="btn btn-info" href="{{ URL::route('user_info', ['id' => $student->id]) }}">Разгледај</a></td>
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
