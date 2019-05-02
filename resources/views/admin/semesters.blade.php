@extends('layouts.app_admin')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Семестри</h6>
            </div>
            <div class="card-body">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">Додај семестар</button>
              <div class="table-responsive" style="margin-top: 20px;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Број на студенти</th>
                      <th>Дата на почеток</th>
                      <th>Дата на крај</th>
                      <th>Акција</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($semestri as $semestar)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $semestar->name }}</td>
                      <td>{{ count($semestar->students()->get()) }}</td>
                      <td>{{ $semestar->start_date }}</td>
                      <td>{{ $semestar->end_date }}</td>
                      <td><a class="btn btn-info" href="#">Измени</a></td>
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
          <h5 class="modal-title" id="exampleModalLabel">Додај семестар</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="inputEmail4">Внеси име:</label>
          <input type="name" class="form-control" id="semestarIme" placeholder="Пр. летен 2019/2020">
          <br>
          <p>Дата на почеток: <input type="text" id="date" class="form-control"></p>
          <p>Дата на крај: <input type="text" id="date1" class="form-control"></p>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Преземи ги темите од минатата година
          </label>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Исклучи</button>
          <button type="button" class="btn btn-primary">Додај</button>
        </div>
      </div>
    </div>
  </div>
@endsection
