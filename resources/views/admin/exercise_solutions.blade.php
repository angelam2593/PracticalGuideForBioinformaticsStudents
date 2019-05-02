@extends('layouts.app_admin_overview')

@section('content')
  <div class="container">
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
      </div>
    @endif
    <div class="row">
    	<div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="background-color: white;">
                  <thead>
                    <tr>
                      <th>Број</th>
                      <th>Име</th>
                      <th>Презиме</th>
                      <th>Индекс</th>
                      <th>Смер</th>
                      <th>Дата на креирање</th>
                      <th>Поени</th>
                      <th>Решение</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($reseni_zadaci as $zadaca)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $zadaca->student->name }}</td>
                      <td>{{ $zadaca->student->surename }}</td>
                      <td>{{ $zadaca->student->userid }}</td>
                      <td>{{ $zadaca->student->smer->ime }}</td>
                      <td>{{ $zadaca->solved_at }}</td>
                      <td>
                        {{ $zadaca->points }} 
                        @include('admin.modal_points')
                      </td>
                      <td><a class="btn btn-primary" href="{{ URL::route('download_solution', ['id' => $zadaca->student->id]) }}">Симни</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
    	</div>
    </div>
</div>
<script>

</script>
@endsection
