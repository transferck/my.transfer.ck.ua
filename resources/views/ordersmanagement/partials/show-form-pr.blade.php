<p><b>{!! trans('forms.create_order_label_fio') !!}: </b>					{{$order->phone}} ({{$order->fio}}) @if($order->phone2 != null), {{$order->phone2}} ({{$order->fio2}}) @else @endif</p>

<p><b>{!! trans('forms.create_order_label_datetimepr') !!}: </b>			{{ \Carbon\Carbon::parse($order->datetime)->format('d.m.Y, H:i')}}</p>
@if($order->airport_ukraine == 'Б')
	<p><b>{!! trans('forms.create_order_label_airportpr') !!}: </b>Борисполь, {{$order->terminal}}</p>
@elseif($order->airport_ukraine == 'Ж')
	<p><b>{!! trans('forms.create_order_label_airportpr') !!}: </b>Жуляны</p>
@else($order->airport_ukraine == 0)
	<p><b>{!! trans('forms.create_order_label_airportpr') !!}: </b>-</p>
@endif
<p><b>{!! trans('forms.create_order_label_airportvl') !!}: </b>				{{$order->airport_world}}, {{$order->flight}}</p>
@if($order->type == 'vl')
	<p><b>{!! trans('forms.create_order_label_address_vl') !!}: </b>				{{$order->address}}</p>
	@if($order->address2 == null)

	@else
		<p><b>{!! trans('forms.create_order_label_address2_vl') !!}: </b>				{{$order->address2}}</p>
	@endif
@elseif($order->type == 'pr')
	<p>
		<b>{!! trans('forms.create_order_label_addresspr') !!}: </b>	
		@if($order->address == 'cherkasy')
			Черкассы
		@elseif($order->address == 'smila')
			Смела
		@else($order->address == 'zolotonosha')
			Золотоноша
		@endif		
	</p>
@else
	<p><b>{!! trans('forms.create_order_label_addressvl') !!}: </b> -</p>
@endif
<p><b>{!! trans('forms.create_order_label_tickets') !!}: </b>				<span class="badge badge-pill badge-soft-dark ml-2">{{$order->tickets}}</span></p>

@if($order->children == null)
	<p>
		<b>{!! trans('forms.create_order_label_children') !!}: </b> <span class="badge badge-pill badge-soft-dark">нет</span> 
		Мест детям: 
		@if($order->ticket_child == null)
			<span class="badge badge-pill badge-soft-dark">0</span>
		@else
			<span class="badge badge-pill badge-soft-dark">{{$order->ticket_child}}</span>
		@endif
	</p>	
@else
	<p>
		<b>{!! trans('forms.create_order_label_children') !!}: </b> <span class="badge badge-pill badge-soft-dark">{{$order->children}}</span> 
		Мест детям: <span class="badge badge-pill badge-soft-dark">{{$order->ticket_child}}</span>
	</p>
@endif

@if($order->transfer == 'group')
	<p><b>{!! trans('forms.create_order_label_transfer') !!}: </b>групповой</p>
@elseif($order->transfer == 'individual')
	<p><b>{!! trans('forms.create_order_label_transfer') !!}: </b>индивидуальный</p>
@else($order->transfer == 0)
	<p><b>{!! trans('forms.create_order_label_transfer') !!}: </b>-</p>
@endif

@if($order->info == null)
	<p><b>{!! trans('forms.create_order_label_info') !!}: </b> <br>нет</p>
@else
	<p><b>{!! trans('forms.create_order_label_info') !!}: </b> {{$order->info}}</p>	
@endif

@if($order->option_babyk == 1)
	<p><b>{!! trans('forms.create_order_label_options') !!} </b><span data-toggle="tooltip" title="Детское автокресло"><i class="fa fa-smile-o" aria-hidden="true"></i></span></p>
@else($order->option_babyk == 0)
	
@endif

@if($order->option_babyl == 1)
	<p><b>{!! trans('forms.create_order_label_options') !!} </b><span data-toggle="tooltip" title="Детская автолюлька"><i class="fa fa-smile-o" aria-hidden="true"></i></span></p>
@else($order->option_babyl == 0)
	 
@endif

@if($order->status_pay == 'not-paid')
	<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.status_pay_1') !!} Пассажир оплачивает водителю</p>
@elseif($order->status_pay == 'paid')

	@if($order->ticketfree_reason == 'customerpaid')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_customerpaid') !!} Оплачено агенством за счет бонусов</p>
	@elseif($order->ticketfree_reason == 'cardpersonal')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardpersonal') !!} Оплачено картой менеджера</p>
	@elseif($order->ticketfree_reason == 'cardgold')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardgold') !!} Оплачено золотой картой разового проезда</p>
	@elseif($order->ticketfree_reason == 'discountfive')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_discountfive') !!}</p>
	@elseif($order->ticketfree_reason == 'discounthalf')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_discounthalf') !!} Оплачено 50% дисконтом менеджера</p>
	@elseif($order->ticketfree_reason == 'balance')
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.ticketfree_reason_balance') !!}</p>
	@else($order->ticketfree_reason == 0)
		<p><b>Cтатус оплаты: </b>{!! trans('ordersmanagement.orders-table.status_pay_2') !!}</p>
	@endif

@else
	<p><b>Cтатус оплаты: </b> -</p>
@endif

@if($order->created_at == $order->updated_at)
	<p><b>Cоздано:</b> {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y, H:i')}}</p>
@else($order->airport_ukraine == 0)
	<p><b>Cоздано:</b> {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y, H:i')}} <b>Изменено:</b> {{ \Carbon\Carbon::parse($order->updated_at)->format('d.m.Y, H:i')}}</p>
@endif

<p><b>Агент:</b>  {{$order->user->name}}</p> 