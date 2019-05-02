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
              <h6 class="m-0 font-weight-bold text-primary">Статус на корисници</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Презиме</th>
                      <th>Тип на корисник</th>
                      <th>Статус</th>
                    </tr>
                  </thead>  
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->surename }}</td>
                      <td>
                        @if($user->admin == 0)
                          Студент
                        @else
                          Администратор
                        @endif
                      </td>
                      <td>
                        @if($user->status == 0)
                          <a class="btn btn-danger" href="#">Деактивирај</a>
                        @else
                          <span class="badge badge-danger">Деактивиран</span>
                        @endif
                      </td>
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
