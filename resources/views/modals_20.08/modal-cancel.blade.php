<div class="modal fade modal-danger" id="confirmСancel" role="dialog" aria-labelledby="confirmСancelLabel"
     aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        {!! Form::open(['method' => 'GET', 'id' => 'modal-form-cancel']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Confirm cancel
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">close</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Сancel this order ?</p>

                <div class="form-group">
                    <label for="cancel_info">Причина отмены:</label>
                    {!! Form::textarea('cancel_info', null, ['id' => 'cancel_info', 'cols' => 30, 'rows' => 2, 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">

                {!! csrf_field() !!}
                {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> Отменить', ['class' => 'btn btn-outline pull-left btn-light', 'type' => 'button', 'data-dismiss' => 'modal']) !!}
                {!! Form::button('<i class="fa fa-fw fa-trash-o" aria-hidden="true"></i> Подтвердить', ['class' => 'btn btn-danger pull-right', 'type' => 'submit', 'id' => 'confirm']) !!}

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
