@extends('layouts.app')

@section('template_title')
    Все брони
@endsection

@section('template_linked_css')

    @if(config('ordersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('ordersmanagement.datatablesCssCDN') }}">
    @endif
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">
    <style type="text/css" media="screen">

        .orders-table {
            border: 0;
        }
		.orders-table .container-fluid,
		.agents-table .container-fluid {
			padding: 0;
		}
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
		.icons-table:after {
			width: 30px;
			content: '';
			display: block;
			background-size: 100%;
			background-position: center;
			background-repeat: no-repeat;
			height: 20px;
		}
		.icons-table {}
		.vl.icons-table:after {
			background-image: url(/images/icons/departure_transfer.svg);
		}		
		.pr.icons-table:after {
			background-image: url(/images/icons/arrival_transfer.svg);
		}		
    </style>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<h5 class="mb-0"> {!! trans('ordersmanagement.showing-orders-all') !!}</h5>
							<div class="pull-right">
							
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<div class="table-responsive orders-table">
								<form id="myForm" class="d-none row" style="padding-bottom:20px;">
									<div class="col-md-5">
										<div class="input-group">
											<input id="from" placeholder="Введите дату" name="from"
												   value="{{Request::get('from')}}"
												   type="text" class="form-control flatpickr-input">
											<div class="input-group-append">
												<label for="datetime" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="input-group">
											<input id="to" placeholder="Введите дату" name="to"
												   value="{{Request::get('to')}}"
												   type="text" class="form-control flatpickr-input">
											<div class="input-group-append">
												<label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
											</div>
										</div>
									</div>

									<button class="btn btn-success" type="submit">
										<i aria-hidden="true" class="fa fa-fw fa-search"></i> Найти
									</button>
								</form>
								
								

                            <table class="table table-striped table-sm data-table" id="all_table">
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('ordersmanagement.orders-table.id') !!}</th>
										<th class="no-search no-sort"></th>
										<th>{!! trans('ordersmanagement.orders-table.airport') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.fio') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="text-center">{!! trans('ordersmanagement.orders-table.tickets') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.r') !!}</th>
										<th>Выл.\прил.</th>
										<th class="no-search no-sort"></th>
										<th class="no-search no-sort"></th>
                                        <th class="w-20">Агент</th>
										<th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="orders_table">
                                    @foreach($orders as $order)
                                        <tr>
											@if($order->created_at == $order->updated_at)
												<td>
													<span data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y, H:i')}}">{{$order->id}}</span>
												</td>
											@else
												<td>
													<span data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y, H:i')}}">{{$order->id}} </span><span data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($order->updated_at)->format('d.m.Y, H:i')}}"><i class="fa fa-pencil" aria-hidden="true"></i></span>
												</td>												
											@endif	
											@if($order->type == 'vl')
												<td><span class="icons-table vl" data-toggle="tooltip" title="Вылет"></span></td>
											@elseif($order->type == 'pr')
												<td><span class="icons-table pr" data-toggle="tooltip" title="Прилёт"></span></td>
											@else($order->type == 0)
												<td>-</td>
											@endif
											<td>{{$order->airport_ukraine}}, {{$order->terminal}}</td>
                                            <td>
												@if($order->phone2 != null) <span data-toggle="tooltip" title="{{$order->phone2}} ({{$order->fio2}})"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> @else @endif
												<span data-toggle="tooltip" title="{{$order->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> 
												<span data-toggle="tooltip" title="{{$order->fio}}">{{str_limit($order->fio, $limit = 12, $end = '...')}}</span>
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
		
											@if($order->type == 'vl')
												<td>{{$order->registration}}</td>
											@elseif($order->type == 'pr')
												<td><span data-toggle="tooltip" title="{{$order->flight}}">{{str_limit($order->flight, $limit = 8, $end = '...')}}</span></td>
												
											@else($order->type == 0)
												<td>-</td>
											@endif		
											
											<td>{{ \Carbon\Carbon::parse($order->datetime)->format('d/m')}}, {{ \Carbon\Carbon::parse($order->datetime)->format('H:i')}}</td>	
											<td>
												@if($order->info == null)
												@else
													<span data-toggle="tooltip" title="{{$order->info}}"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
												@endif	
											</td>
											<td>
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
											@if($order->status_pay == 'not-paid')
												{!! trans('ordersmanagement.orders-table.status_pay_1') !!}
											@elseif($order->status_pay == 'paid')
												
													@if($order->ticketfree_reason == 'customerpaid')
														{!! trans('ordersmanagement.orders-table.ticketfree_reason_customerpaid') !!}
													@elseif($order->ticketfree_reason == 'cardpersonal')
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
												
											@else
												-
											@endif
											</td>
											<td><span data-toggle="tooltip" title="{{$order->user->name}}">{{str_limit($order->user->name, $limit = 15, $end = '...')}}</span></td>
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

														@role('admin') 
														<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
															{!! trans('ordersmanagement.buttons.edit') !!}
														</a>
														
														{!! Form::open(array('url' => 'orders/' . $order->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
															{!! Form::hidden('_method', 'DELETE') !!}
															{!! Form::button(trans('ordersmanagement.buttons.delete'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
														{!! Form::close() !!}
														@endrole
														
														<div class="dropdown-divider"></div>
														@if($order->status_order != 'reservation')
														{!! Form::open(array('url' => 'orders/' . $order->id . '/reservation', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Подтвердить бронь' )) !!}
															{!! Form::hidden('_method', 'GET') !!}
															{!! Form::button(trans('ordersmanagement.buttons.reservation'), array('class' => 'dropdown-item text-success','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmReservation', 'data-title' => 'Одобрить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
														{!! Form::close() !!}
														@elseif($order->status_order == 'reservation')
														@endif
														
														{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
                                                            {!! Form::hidden('_method', 'GET') !!}
                                                            {!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
														{!! Form::close() !!}
														
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

                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<h5 class="mb-0"> {!! trans('ordersmanagement.showing-orders-cancel-all') !!}</h5>
							<div class="pull-right">
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<div class="table-responsive orders-table">
                            <table class="table table-striped table-sm data-table" id="orders_table">
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('ordersmanagement.orders-table.id') !!}</th>
										<th class="no-search no-sort"></th>
										<th>{!! trans('ordersmanagement.orders-table.airport') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.fio') !!}</th>
										<th class="text-center">{!! trans('ordersmanagement.orders-table.tickets') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.r') !!}</th>
										<th>{!! trans('ordersmanagement.orders-table.datetime-vl') !!}</th>
										<th class="no-search no-sort"></th>
										<th class="no-search no-sort"></th>
										<th class="no-search no-sort"></th>
                                        <th>Агент</th>
										<th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="orders_table">
                                    @foreach($orders_cancel as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
											@if($order->type == 'vl')
												<td><span class="icons-table vl" data-toggle="tooltip" title="Вылет"></span></td>
											@elseif($order->type == 'pr')
												<td><span class="icons-table pr" data-toggle="tooltip" title="Прилёт"></span></td>
											@else($order->type == 0)
												<td>-</td>
											@endif
											<td>{{$order->airport_ukraine}}, {{$order->terminal}}</td>
                                            <td>
												@if($order->phone2 != null) <span data-toggle="tooltip" title="{{$order->phone2}} ({{$order->fio2}})"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> @else @endif
												<span data-toggle="tooltip" title="{{$order->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> 
												<span data-toggle="tooltip" title="{{$order->fio}}">{{str_limit($order->fio, $limit = 12, $end = '...')}}</span>
											</td>
											<td class="text-center">{{$order->tickets + $order->children}}</td>
											
											
											@if($order->type == 'vl')
												<td>{{$order->registration}}</td>
											@elseif($order->type == 'pr')
												<td>{{$order->flight}}</td>
											@else($order->type == 0)
												<td>-</td>
											@endif		
											
											<td>{{ \Carbon\Carbon::parse($order->datetime)->format('d/m')}}, {{ \Carbon\Carbon::parse($order->datetime)->format('H:i')}}</td>
											<td>
												@if($order->info == null)
												@else
													<span data-toggle="tooltip" title="{{$order->info}}"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
												@endif	
											</td>												
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
												<td>{!! trans('ordersmanagement.orders-table.status_pay_2') !!}</td>
											@else($order->status_order == 0)
												<td>-</td>
											@endif
											<td>{{$order->user->name}}</td>
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

														@role('admin') 
														<a class="dropdown-item" href="{{ URL::to('orders/' . $order->id . '/edit') }}">
															{!! trans('ordersmanagement.buttons.edit') !!}
														</a>
														
														{!! Form::open(array('url' => 'orders/' . $order->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
															{!! Form::hidden('_method', 'DELETE') !!}
															{!! Form::button(trans('ordersmanagement.buttons.delete'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
														{!! Form::close() !!}
														@endrole
														
														<div class="dropdown-divider"></div>
														@if($order->status_order != 'reservation')
														{!! Form::open(array('url' => 'orders/' . $order->id . '/reservation', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Подтвердить бронь' )) !!}
															{!! Form::hidden('_method', 'GET') !!}
															{!! Form::button(trans('ordersmanagement.buttons.reservation'), array('class' => 'dropdown-item text-success','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmReservation', 'data-title' => 'Одобрить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
														{!! Form::close() !!}
														@elseif($order->status_order != 'success')
														{!! Form::open(array('url' => 'orders/' . $order->id . '/cancel', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Отменить бронь' )) !!}
                                                            {!! Form::hidden('_method', 'GET') !!}
                                                            {!! Form::button(trans('ordersmanagement.buttons.cancel'), array('class' => 'dropdown-item text-danger','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmСancel', 'data-title' => 'Отменить бронь', 'data-message' => 'Вы уверены, что хотите изменить статус брони?')) !!}
														{!! Form::close() !!}
														@endif
														
														
													</div>
												</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                        
			</div>
			
            <div class="col-sm-3">
                <div class="card">
					<div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<h5 class="mb-0"> {!! trans('ordersmanagement.showing-users-all') !!}</h5>
							<div class="pull-right">

							</div>
						</div>
                    </div>
                    <div class="card-body">
                        <!--
                        @if(config('usersmanagement.enableSearchUsers'))
                            @include('partials.search-users-form')
                        @endif
                        -->
                        <div class="table-responsive agents-table">
                            <table id="agents_table" class="table table-striped table-sm data-table">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th class="no-search no-sort"></th>
										<th class="no-search no-sort"><span data-toggle="tooltip" title="Уровень">У</span></th>
										<th class="no-search no-sort"><span data-toggle="tooltip" title="Броней">Б</span></th>
										<th class="no-search no-sort"><span data-toggle="tooltip" title="Пассажиров">П</span></th>
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($users as $user)
                                        @if(!$user->isAgent()) @continue @endif
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
												<span data-toggle="tooltip" title="{{$user->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> {{$user->name}} 
											</td>
                                            @php $pass = $user->orders->sum('tickets') + $user->orders->sum('children');  @endphp
                                            <td>
                                                @if($pass == 0) 0 @endif
                                                @if($pass > 0 && $pass <= 7) 3 @endif
                                                @if($pass >= 8 && $pass < 19) 2 @endif
                                                @if($pass >= 20 ) 1 @endif
                                            </td>
                                            <td>{{$user->orders->count()}}</td>
                                            <td>{{$pass}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('usersmanagement.enableSearchOrders'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

                            @if(config('usersmanagement.enablePagination'))
                                {{ $users->links() }}
                            @endif

                        </div>
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

	@include('scripts.datatables')

	<script src="{{asset('js/flatpickr.min.js')}}"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

	<script>
		flatpickr("#to", {
			locale: "ru",
			enableTime: false,
			dateFormat: "Y-m-d",
			time_24hr: true,
		});
		flatpickr("#from", {
			locale: "ru",
			enableTime: false,
			dateFormat: "Y-m-d",
			time_24hr: true,
		});
	</script>

    @include('scripts.delete-modal-script')
    @include('scripts.reservation-modal-script')
    @include('scripts.cancel-modal-script')
    @include('scripts.save-modal-script')
    @if(config('ordersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('ordersmanagement.enableSearchOrders'))
        @include('scripts.search-orders')
    @endif
@endsection
