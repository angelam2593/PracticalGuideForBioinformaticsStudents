<a href="#modal_dp_{{ $zadaca->id }}">
  <i id="add_points" class="fas fa-fw fa-pen" data-toggle="modal" data-target="#modal_{{ $zadaca->id }}"></i></a>
  {!! Form::open(['url' => 'admin/addPoints/{$zadaca->id}']) !!}
  {!! Form::hidden('zadaca_id', $zadaca->id) !!}
  <div class="modal fade" id="modal_{{ $zadaca->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal_dp_{{ $zadaca->id }}">
    <div class="modal-dialog" role="document"> 
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Поени</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              {{ Form::text('points', null, ['class' => 'form-control']) }}<br>
              {{ Form::submit('Запамти', ['class' => 'form-control btn btn-primary']) }}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Исклучи</button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}