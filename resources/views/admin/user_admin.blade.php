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
              <h6 class="m-0 font-weight-bold text-primary">Администратори</h6>
            </div>
            <div class="card-body">
             <div class="dropdown mb-4">
                <a class="btn btn-primary" href="{{ URL::route('add_admin') }}">Додај администратор</a>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Презиме</th>
                      <th>Дата на креирање</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($administratori as $administrator)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $administrator->name }}</td>
                      <td>{{ $administrator->surename }}</td>
                      <td>{{ $administrator->created_at }}</td>
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
