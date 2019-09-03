<div class="modal fade modal-success" id="confirmReservation" role="dialog" aria-labelledby="confirmReservationLabel" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
			Забронировать
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">close</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{!! trans('ordersmanagement.modals.reservation_order_message', ['order' => $order->id]) !!}</p>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> Отменить', array('class' => 'btn btn-outline pull-left btn-light', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
        {!! Form::button('<i class="fa fa-fw fa-trash-o" aria-hidden="true"></i> Подтвердить бронирование', array('class' => 'btn btn-success pull-right', 'type' => 'button', 'id' => 'confirm' )) !!}
      </div>
    </div>
  </div>
</div>
