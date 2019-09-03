@extends('layouts.app')

@section('template_title')
  {!! trans('ordersmanagement.showing-order', ['fio' => $order->fio]) !!}
@endsection

@section('template_fastload_css')
	.control-label{
		font-weight: 700;
	}
	.hidden {
		display: none !important;
	}		
	.item div {
		display: none;
	}
	.item input:first-of-type:checked ~ div:first-of-type  {
		display: block;
	}
	.item input:last-of-type:checked ~ div:last-of-type  {
		display: block;
	}	
	h5 {
		margin: 0;
	}	
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <h5>
                            {!! trans('ordersmanagement.showing-order', ['id' => $order->id]) !!}
							@if($order->status_order == 'sent')
								{!! trans('ordersmanagement.orders-table.status_order_sent') !!}
							@elseif($order->status_order == 'reservation')
								{!! trans('ordersmanagement.orders-table.status_order_reservation') !!}
							@elseif($order->status_order == 'cancel')
								{!! trans('ordersmanagement.orders-table.status_order_cancel') !!}
							@elseif($order->status_order == 'moved')
								{!! trans('ordersmanagement.orders-table.status_order_moved') !!}
							@elseif($order->status_order == 'update')
								{!! trans('ordersmanagement.orders-table.status_order_update') !!}
							@elseif($order->status_order == 'success')
								{!! trans('ordersmanagement.orders-table.status_order_success') !!}
							@else($order->status_order == 0)
								-
							@endif
                            <div class="pull-right">
								@role('admin')
                                <a href="{{ route('orders') }}" class="btn btn-light btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-orders') !!}
                                </a>
								@endrole
								@role('operator')
                                <a href="{{ route('orders-all') }}" class="btn btn-light btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-orders') !!}
                                </a>
								@endrole
								@role('agent')
                                <a href="{{ route('orders') }}" class="btn btn-light btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-orders') !!}
                                </a>
								@endrole
								
								@role('operator')
                                    <button type="button" class="btn btn-default dropdown-toggle float-right mt-0 pt-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">
															{!! trans('ordersmanagement.orders-menu-alt') !!}
														</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right bg-white py-2">
                                        @role('admin')
                                        <a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
                                            {!! trans('ordersmanagement.buttons.edit') !!}
                                        </a>

                                        {!! Form::open(array('url' => 'orders/' . $order->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button(trans('ordersmanagement.buttons.delete'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
                                        {!! Form::close() !!}
                                        <div class="dropdown-divider"></div>
										@endrole

                                        
                                        @if($order->status_order != 'reservation')
                                            {!! Form::open(array('url' => 'orders/' . $order->id . '/reservation', 'class' => '', 'data-toggle' => 'tooltip', 'title' => '' )) !!}
                                            {!! Form::hidden('_method', 'GET') !!}
                                            {!! Form::button(trans('ordersmanagement.buttons.reservation'), array('class' => 'dropdown-item text-success','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmReservation', 'data-title' => 'Одобрить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
                                            {!! Form::close() !!}
                                        @elseif($order->status_order != 'success')
                                            {!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => '' )) !!}
                                            {!! Form::hidden('_method', 'GET') !!}
                                            {!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
                                            {!! Form::close() !!}
                                        @endif


                                    </div>
								@endrole	
                                </div>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($order->type == 'vl')
							@include('ordersmanagement.partials.show-form-vl')
                        @elseif($order->type == 'pr')
                            @include('ordersmanagement.partials.show-form-pr')
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

  @include('modals.modal-delete')
  @include('modals.modal-reservation')
  @include('modals.modal-cancel')

@endsection

@section('footer_scripts')
  @include('scripts.delete-modal-script')
  @include('scripts.reservation-modal-script')
  @include('scripts.cancel-modal-script')
  @include('scripts.save-modal-script')
  @if(config('ordersmanagement.tooltipsEnabled'))
      @include('scripts.tooltips')
  @endif
@endsection
