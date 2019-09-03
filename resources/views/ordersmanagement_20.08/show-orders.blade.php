@extends('layouts.app')

@section('template_title')
    {!! trans('ordersmanagement.showing-orders-vl') !!}
@endsection

@section('template_linked_css')
    @if(config('ordersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('ordersmanagement.datatablesCssCDN') }}">
    @endif
	<link href="/css/dataTables.bootstrap-v3.css" rel="stylesheet">	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">
    <style type="text/css" media="screen">

        .orders-table {
            border: 0;
        }
		.orders-table .container-fluid {padding: 0;}
        .orders-table tr td:first-child {
            padding-left: 15px;
        }
        .orders-table tr td:last-child {
            padding-right: 15px;
        }
        .orders-table.table-responsive,
        .orders-table.table-responsive table {
            margin-bottom: 0;
        }
		#orders_table .btn-group .btn {
			padding: 0;
		}
		#orders_table .btn-group .dropdown-toggle::after {
			display: none;
		}
		.icons-table {}
		.icons-table:before {
			width: 30px;
			content: '';
			display: -webkit-inline-box;
			background-size: 100%;
			background-position: center;
			background-repeat: no-repeat;
			height: 15px;
			margin-right: 10px;
		}		
		.vl.icons-table:before {
			background-image: url(/images/icons/departure_transfer.svg);
		}		
		.pr.icons-table:before {
			background-image: url(/images/icons/arrival_transfer.svg);
		}			
    </style>
@endsection

@section('content')
    <div class="container-fluid">
		<div class="d-block text-right">
			<a class="btn btn-success {{ Request::is('/orders/create') ? 'active' : null }}" href="{{ url('/orders/create') }}">{!! trans('titles.agentNewOrder') !!}</a>
			@role('admin')
				<a class="btn btn-danger {{ Request::is('/orders/deleted') ? 'active' : null }}" href="{{ url('/orders/deleted') }}">{!! trans('titles.agentDeleteOrder') !!}</a>
			@endrole
		</div>		
        <div class="row">
            <div class="col-sm-6 col-md-12 col-lg-6 col-xl-6 mt-3">
                <div class="card">
                    <div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<h5 class="vl icons-table mb-0"> {!! trans('ordersmanagement.showing-orders-vl') !!}</h5>
						</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive orders-table">
							<form id="departure_table_form" class="form-row" style="margin:0;">
								<div class="col-md-3">
									<div class="input-group">
										<input id="departure_table_id" placeholder="Введите ID" name="id"
											   value="{{Request::get('id')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-bars"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<input id="departure_table_name" placeholder="Введите имя" name="name"
											   value="{{Request::get('name')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-user"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<input id="departure_table_phone" placeholder="Введите номер" name="phone"
											   value="{{Request::get('phone')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-phone"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<select id="departure_table_status" class="custom-select custom-select-sm form-control">
										<option value="" selected>Все брони</option>
										<option value="sent">Отправлено</option>
										<option value="reservation">Забронировано</option>
										<option value="update">Изменено</option>
										<option value="cancel">Отменено</option>
										<option value="success">Выполнено</option>
									</select>
								</div>
								<div class="col-md-3 mt-2">
									<div class="input-group">
										<input id="departure_table_from" placeholder="Введите дату" name="from"
											   type="text" class="form-control form-control-sm flatpickr-input">
										<div class="input-group-append">
											<label for="datetime" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3 mt-2">
									<div class="input-group">
										<input id="departure_table_to" placeholder="Введите дату" name="to"
											   type="text" class="form-control form-control-sm flatpickr-input">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3 mt-2">
									<button class="btn btn-sm btn-success" type="submit">
										<i aria-hidden="true" class="fa fa-fw fa-search"></i> Найти
									</button>
									<button class="btn btn-info btn-sm" id="departure_table_reset">
										<i aria-hidden="true" class="fa fa-fw fa-undo"></i>
									</button>
								</div>
							</form>
                            <table class="table table-hover table-striped table-sm data-table" id="departure_table">
                                <thead class="thead">
                                    <tr>
                                        <th class="departure_table_order" data-col="id">{!! trans('ordersmanagement.orders-table.id') !!}</th>
                                        <th class="departure_table_order" data-col="fio">{!! trans('ordersmanagement.orders-table.fio') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="text-center">{!! trans('ordersmanagement.orders-table.tickets') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.airport') !!}</th>
										<th class="departure_table_order" data-col="datetime">{!! trans('ordersmanagement.orders-table.datetime-vl') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.registration') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="orders_table">
                                    @foreach($orders_vl as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td><span data-toggle="tooltip" title="{{$order->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> {{$order->fio}}</td>
											<td>
												@if($order->option_babyk == 1)
													<span data-toggle="tooltip" title="Детское автокресло"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
												@else($order->option_babyk == 0)
													
												@endif
												
												@if($order->option_babyl == 1)
													<span data-toggle="tooltip" title="Детская автолюлька"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
												@else($order->option_babyl == 0)
													 
												@endif
											</td>
											@if($order->ticket_child == 0)
												<td class="text-center">{{$order->tickets}}</td>
											@elseif($order->ticket_child > 0)
												<td class="text-center">{{$order->tickets}}+{{$order->ticket_child}}</td>
											@else
												<td class="text-center">-</td>
											@endif
											<td>{{$order->airport_ukraine}}, {{$order->terminal}}</td>

											<td>{{ \Carbon\Carbon::parse($order->datetime)->format('d.m')}}, {{ \Carbon\Carbon::parse($order->datetime)->format('H:i')}}</td>

											@if($order->type == 'vl')
												<td>{{$order->registration}}</td>
											@elseif($order->type == 'pr')
												<td>{{$order->flight}}</td>
											@else($order->type == 0)
												<td>-</td>
											@endif	
											
											@if($order->status_order == 'sent')
												<td>{!! trans('ordersmanagement.orders-table.status_order_sent') !!}</td>
											@elseif($order->status_order == 'reservation')
												<td>{!! trans('ordersmanagement.orders-table.status_order_reservation') !!} </td>
											@elseif($order->status_order == 'cancel')
												<td>{!! trans('ordersmanagement.orders-table.status_order_cancel') !!} </td>
											@elseif($order->status_order == 'moved')
												<td>{!! trans('ordersmanagement.orders-table.status_order_moved') !!}</td>
											@elseif($order->status_order == 'update')
												<td>{!! trans('ordersmanagement.orders-table.status_order_update') !!}</td>
											@elseif($order->status_order == 'success')
												<td>{!! trans('ordersmanagement.orders-table.status_order_success') !!}</td>												
											@else($order->status_order == 0)
												<td>-</td>
											@endif
											@if($order->status_pay == 'not-paid')
												<td>{!! trans('ordersmanagement.orders-table.status_pay_1') !!}</td>
											@elseif($order->status_pay == 'paid')
												<td>
													@if($order->ticketfree_reason == 'cardpersonal')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardpersonal') !!}
													@elseif($order->ticketfree_reason == 'cardgold')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardgold') !!}
													@elseif($order->ticketfree_reason == 'discountfive')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_discountfive') !!}
													@elseif($order->ticketfree_reason == 'discounthalf')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_discounthalf') !!}
													@elseif($order->ticketfree_reason == 'balance')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_balance') !!}
													@else($order->ticketfree_reason == 0)
														{!! trans('ordersmanagement.orders-table.status_pay_2') !!}
													@endif
												</td>
											@else
												<td>-</td>
											@endif
                                            <td>
												<div class="btn-group pull-right btn-group-xs">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
														<span class="sr-only">
															{!! trans('ordersmanagement.orders-menu-alt') !!}
														</span>
													</button>
													<div class="dropdown-menu dropdown-menu-right bg-white py-2">
														@role('admin')
															<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id) }}">
																{!! trans('ordersmanagement.buttons.show') !!}
															</a>
															@if($order->status_order != 'success')
																<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
																	{!! trans('ordersmanagement.buttons.edit') !!}
																</a>
																<div class="dropdown-divider"></div>
																{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
																	{!! Form::hidden('_method', 'GET') !!}
																	{!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
																{!! Form::close() !!}
															@endif

															<div class="dropdown-divider"></div>
															{!! Form::open(array('url' => 'orders/' . $order->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
																{!! Form::hidden('_method', 'DELETE') !!}
																{!! Form::button(trans('ordersmanagement.buttons.delete'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
															{!! Form::close() !!}
														@endrole

														@role('agent')
															@if($ownOrdersIds->contains($order->id))
																<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id) }}">
																	{!! trans('ordersmanagement.buttons.show') !!}
																</a>

																@if($order->status_order != 'success')
																	<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
																		{!! trans('ordersmanagement.buttons.edit') !!}
																	</a>
																@endif
															@endif

															@if($order->status_order != 'success')
																<div class="dropdown-divider"></div>
																{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
																{!! Form::hidden('_method', 'GET') !!}
																{!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
																{!! Form::close() !!}
															@endif
														@endrole

														@role('operator')
															<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id) }}">
																{!! trans('ordersmanagement.buttons.show') !!}
															</a>
															@if($order->status_order != 'success')
																{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
																{!! Form::hidden('_method', 'GET') !!}
																{!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
																{!! Form::close() !!}
															@endif
														@endrole
													</div>
												</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('ordersmanagement.enableSearchOrders'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

							<div class="dataTables_info" id="departure_table_info" role="status" aria-live="polite">Записи с
								1 до 10 из {{ $orders_vl->count() }} записей</div>
							<div class="d-flex justify-content-between align-items-center">
								<div class="dataTables_paginate" id="departure_table_pagination">

								</div>

								<div class="dataTables_paginate" id="departure_table_count">

								</div>
							</div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-12 col-lg-6 col-xl-6 mt-3">
                <div class="card">
					<div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<h5 class="pr icons-table mb-0"> {!! trans('ordersmanagement.showing-orders-pr') !!}</h5>
						</div>
                    </div>
                    <div class="card-body">						 
                        <div class="table-responsive orders-table">
							<form id="arrival_table_form" class="form-row" style="margin:0;">
								<div class="col-md-3">
									<div class="input-group">
										<input id="arrival_table_id" placeholder="Введите ID" name="id"
											   value="{{Request::get('id')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-bars"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<input id="arrival_table_name" placeholder="Введите имя" name="name"
											   value="{{Request::get('name')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-user"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<input id="arrival_table_phone" placeholder="Введите номер" name="phone"
											   value="{{Request::get('phone')}}"
											   type="text" class="form-control form-control-sm">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-phone"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<select id="arrival_table_status" class="custom-select custom-select-sm form-control">
										<option value="" selected>Все брони</option>
										<option value="sent">Отправлено</option>
										<option value="reservation">Забронировано</option>
										<option value="update">Изменено</option>
										<option value="cancel">Отменено</option>
										<option value="success">Выполнено</option>
									</select>
								</div>
								<div class="col-md-3 mt-2">
									<div class="input-group">
										<input id="arrival_table_from" placeholder="Введите дату" name="from"
											   value="{{Request::get('from')}}"
											   type="text" class="form-control form-control-sm flatpickr-input">
										<div class="input-group-append">
											<label for="datetime" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3 mt-2">
									<div class="input-group">
										<input id="arrival_table_to" placeholder="Введите дату" name="to"
											   type="text" class="form-control form-control-sm flatpickr-input">
										<div class="input-group-append">
											<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
										</div>
									</div>
								</div>
								<div class="col-md-3 mt-2">
									<button class="btn btn-sm btn-success" type="submit">
										<i aria-hidden="true" class="fa fa-fw fa-search"></i> Найти
									</button>
									<button class="btn btn-info btn-sm" id="arrival_table_reset">
										<i aria-hidden="true" class="fa fa-fw fa-undo"></i>
									</button>
								</div>
							</form>
                            <table class="table table-hover table-striped table-sm data-table" id="arrival_table">
                                <thead class="thead">
                                    <tr>
                                        <th class="arrival_table_order" data-col="id">{!! trans('ordersmanagement.orders-table.id') !!}</th>
                                        <th class="arrival_table_order" data-col="fio">{!! trans('ordersmanagement.orders-table.fio') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="text-center">{!! trans('ordersmanagement.orders-table.tickets') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.airport') !!}</th>
										<th class="arrival_table_order" data-col="datetime">{!! trans('ordersmanagement.orders-table.datetime-pr') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.flight') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="orders_table">
                                    @foreach($orders_pr as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>
												<span data-toggle="tooltip" title="{{$order->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> {{$order->fio}} 
											</td>
                                         
											<td>
												@if($order->option_nameplate == 1)
													<span data-toggle="tooltip" title="Встреча с табличкой"><i class="fa fa-window-maximize" aria-hidden="true"></i></span>
												@else($order->option_nameplate == 0)
												@endif
											
												@if($order->option_babyk == 1)
													<span data-toggle="tooltip" title="Детское автокресло"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
												@else($order->option_babyk == 0)
													
												@endif
												
												@if($order->option_babyl == 1)
													<span data-toggle="tooltip" title="Детская автолюлька"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
												@else($order->option_babyl == 0)
													 
												@endif
											</td>
																				
											@if($order->ticket_child == 0)
												<td class="text-center">{{$order->tickets}}</td>
											@elseif($order->ticket_child > 0)
												<td class="text-center">{{$order->tickets}}+{{$order->ticket_child}}</td>
											@else
												<td class="text-center">-</td>
											@endif
											<td>{{$order->airport_ukraine}}, {{$order->terminal}}</td>
											<td>{{ \Carbon\Carbon::parse($order->datetime)->format('d.m')}}, {{ \Carbon\Carbon::parse($order->datetime)->format('H:i')}}</td>			
											<td><span data-toggle="tooltip" title="Вылетел с {{$order->airport_world}}">{{$order->flight}}</span></td>
											@if($order->status_order == 'sent')
												<td>{!! trans('ordersmanagement.orders-table.status_order_sent') !!}</td>
											@elseif($order->status_order == 'reservation')
												<td>{!! trans('ordersmanagement.orders-table.status_order_reservation') !!} </td>
											@elseif($order->status_order == 'cancel')
												<td>{!! trans('ordersmanagement.orders-table.status_order_cancel') !!} </td>
											@elseif($order->status_order == 'moved')
												<td>{!! trans('ordersmanagement.orders-table.status_order_moved') !!}</td>
											@elseif($order->status_order == 'update')
												<td>{!! trans('ordersmanagement.orders-table.status_order_update') !!}</td>
											@elseif($order->status_order == 'success')
												<td>{!! trans('ordersmanagement.orders-table.status_order_success') !!}</td>												
											@else($order->status_order == 0)
												<td>-</td>
											@endif
											
											@if($order->status_pay == 'not-paid')
												<td>{!! trans('ordersmanagement.orders-table.status_pay_1') !!}</td>
											@elseif($order->status_pay == 'paid')
												<td>
													@if($order->ticketfree_reason == 'cardpersonal')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardpersonal') !!}
													@elseif($order->ticketfree_reason == 'cardgold')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardgold') !!}
													@elseif($order->ticketfree_reason == 'discountfive')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_discountfive') !!}
													@elseif($order->ticketfree_reason == 'discounthalf')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_discounthalf') !!}
													@elseif($order->ticketfree_reason == 'balance')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_balance') !!}
													@else($order->ticketfree_reason == 0)
														{!! trans('ordersmanagement.orders-table.status_pay_2') !!}
													@endif
												</td>
											@else
												<td>-</td>
											@endif	
											
                                            <td>
												<div class="btn-group pull-right btn-group-xs">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
														<span class="sr-only">
															{!! trans('ordersmanagement.orders-menu-alt') !!}
														</span>
													</button>
													<div class="dropdown-menu dropdown-menu-right bg-white py-2">
														<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id) }}">
															{!! trans('ordersmanagement.buttons.show') !!}
														</a>	
														@if($order->status_order != 'success')
															<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
																{!! trans('ordersmanagement.buttons.edit') !!}
															</a>
															<div class="dropdown-divider"></div>
															{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
																{!! Form::hidden('_method', 'GET') !!}
																{!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
															{!! Form::close() !!}
														@endif	
														@role('admin')
															<div class="dropdown-divider"></div>
															{!! Form::open(array('url' => 'orders/' . $order->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
																{!! Form::hidden('_method', 'DELETE') !!}
																{!! Form::button(trans('ordersmanagement.buttons.delete'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
															{!! Form::close() !!}
														@endrole															
													</div>
												</div>
                                            </td>
											<td style="display: none">{{$order->updated_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('ordersmanagement.enableSearchOrders'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

							<div class="dataTables_info" id="arrival_table_info" role="status" aria-live="polite">Записи с
								1 до 10 из {{ $orders_vl->count() }} записей</div>
							<div class="d-flex justify-content-between align-items-center">
								<div class="dataTables_paginate" id="arrival_table_pagination">

								</div>

								<div class="dataTables_paginate" id="arrival_table_count">

								</div>
							</div>

                        </div>
                    </div>
                </div>
            </div>			
        </div>
	</div>

    @include('modals.modal-delete')
	@include('modals.modal-cancel')

@endsection

@section('footer_scripts')
	@include('scripts.datatables2', [
		'ownItemsIds' => $ownOrdersIds
	])
    @include('scripts.delete-modal-script')
    @include('scripts.cancel-modal-script')	
    @include('scripts.save-modal-script')
    @if(config('ordersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('ordersmanagement.enableSearchOrders'))
        @include('scripts.search-orders')
    @endif
@endsection
