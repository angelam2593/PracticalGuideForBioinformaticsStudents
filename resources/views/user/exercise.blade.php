@extends('layouts.app')

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
    		<div class="col-md-12"><h4>{{ $zadaca->title }}</h4></div>
    	</div>
    </div>
    <div class="col-md-12">
        <p>
            {!! $zadaca->description !!}
        </p>
    </div>
    <hr>
    <div class="col-md-12">
        <h5><b>Example input:</b></h5><p>{!! $zadaca->test_input !!}</p>
    </div>
    <div class="col-md-12">
        <h5><b>Example output:</b></h5><p>{!! $zadaca->test_output !!}</p>
    </div>
    <div class="col-md-12">
        <form action="{{URL::to('user/uploadFile/')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label>File *</label>
                <input type="file" name="file_to_verify">
            </div>
            <input type="submit" class="btn btn-primary btn-block" value="Upload File">
        </form>
    </div>
</div>
@endsection
