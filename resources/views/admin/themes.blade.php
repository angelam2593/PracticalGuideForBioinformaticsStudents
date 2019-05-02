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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Тематики</h6>
            </div>
            <div class="card-body">
               <div class="dropdown mb-4">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Избери година
                  </button>
                  <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{ URL::route('show_godiniZaTema', ['id' => 0]) }}">Сите години</a>
                      @foreach($godini as $godina)
                        <a class="dropdown-item" href="{{ URL::route('show_godiniZaTema', ['id' => $godina->id]) }}">{{ $godina->name }}</a>
                      @endforeach
                  </div>
                <a class="btn btn-primary" href="{{ URL::route('add_theme') }}">Додади тема</a>
                </div>
              <!--<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Додај тема</button>-->
              <div class="table-responsive" style="margin-top:20px;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Број на задачи</th>
                      <th>Година/Семестар</th>
                      <th>Дата на почеток</th>
                      <th>Дата на завршување</th>
                      <th>Акции</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($temi as $tema)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tema->title }}</td>
                        <td>{{ count($tema->exercises) }}</td>
                        <td>{{ $tema->year->name }}</td>
                        <td>{{ $tema->data_pocetok }}</td>
                        <td>{{ $tema->data_kraj }}</td>
                        <td><a class="btn btn-info" href="{{ URL::route('theme_edit', ['id' => $tema->id]) }}">Измени</a></td>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Додај тема</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Date: <input type="text" id="date"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
