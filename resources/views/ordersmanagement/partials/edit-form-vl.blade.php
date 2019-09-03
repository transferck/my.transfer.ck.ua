{!! Form::open(['route' => ['orders.update', $order->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'vilet']) !!}

{!! csrf_field() !!}
<div class="form-row">
	<div class="col-sm-7">
		<div class="form-group has-feedback {{ $errors->has('fio') ? ' has-error ' : '' }}">
			{!! Form::label('fio', trans('forms.create_order_label_fio'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="fio">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_fio') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('fio', $order->fio, array('id' => 'fio', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
				</div>
				@if ($errors->has('fio'))
					<span class="help-block">
						<strong>{{ $errors->first('fio') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-5">
		<div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error ' : '' }}">
			{!! Form::label('phone', trans('forms.create_order_label_phone'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="fio">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_phone') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('phone', $order->phone, array('id' => 'phone', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
					@if($order->fio2 == null)
						<div id="p-caption-hide" class="input-group-prepend btn btn-danger ml-2">
							<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
						</div>
						<div id="p-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: block;">
							<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
						</div>
					@else
						<div id="p-caption-hide" class="input-group-prepend btn btn-danger ml-2" style="display: block;">
							<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
						</div>
						<div id="p-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: none;">
							<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
						</div>
					@endif
				</div>
				<span class="info-block d-none"><small>В международном формате: +380</small></span>
				@if ($errors->has('phone'))
					<span class="help-block">
						<strong>{{ $errors->first('phone') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

@if($order->fio2 == null)
<div class="form-row hidden-area">
@else
<div class="form-row hidden-area" style="display: flex;">
@endif
	<div class="col-sm-7">
		<div class="form-group has-feedback {{ $errors->has('fio2') ? ' has-error ' : '' }}">
			{!! Form::label('fio2', trans('forms.create_order_label_fio2'), array('class' => 'col-md-12 control-label')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="fio2">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_fio') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('fio2', $order->fio2, array('id' => 'fio2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
				</div>
				@if ($errors->has('fio2'))
					<span class="help-block">
						<strong>{{ $errors->first('fio2') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-5">
		<div class="form-group has-feedback {{ $errors->has('phone2') ? ' has-error ' : '' }}">
			{!! Form::label('phone2', trans('forms.create_order_label_phone'), array('class' => 'col-md-12 control-label')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="fio">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_phone') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('phone2', $order->phone2, array('id' => 'phone2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
				</div>
				<span class="info-block d-none"><small>В международном формате: +380</small></span>
				@if ($errors->has('phone2'))
					<span class="help-block">
						<strong>{{ $errors->first('phone2') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="form-row">
    <div class="col-sm-3">
        <div class="form-group has-feedback {{ $errors->has('date') ? ' has-error ' : '' }}">
            {!! Form::label('date', trans('forms.create_order_label_datevl'), array('class' => 'col-md-12 control-label required')); !!}
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="datetime">
                            <i class="fa fa-fw {{ trans('forms.create_order_icon_datetimevl') }}" aria-hidden="true"></i>
                        </label>
                    </div>
                    {!! Form::text('date', DateTime::createFromFormat('Y-m-d H:i:s', $order->datetime)->format('Y-m-d'), array('id' => 'date', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('forms.create_order_ph_datetimevl'))) !!}
                </div>
                @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group has-feedback {{ $errors->has('time') ? ' has-error ' : '' }}">
            {!! Form::label('time', trans('forms.create_order_label_timevl'), array('class' => 'col-md-12 control-label required')); !!}
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="datetime">
                            <i class="fa fa-fw {{ trans('forms.create_order_icon_datetimevl') }}" aria-hidden="true"></i>
                        </label>
                    </div>
                    {!! Form::text('time', DateTime::createFromFormat('Y-m-d H:i:s', $order->datetime)->format('H:i'), array('id' => 'time', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('forms.create_order_ph_datetimevl'))) !!}
                </div>
                @if ($errors->has('time'))
                    <span class="help-block">
                        <strong>{{ $errors->first('time') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>	
	<div class="col-sm-3">
		<div class="form-group has-feedback {{ $errors->has('airport_ukraine') ? ' has-error ' : '' }}">
			{!! Form::label('airport_ukraine', trans('forms.create_order_label_airportvl'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control airportvl-select" name="airport_ukraine" id="airport_ukraine">
					<option value="0">{{ trans('forms.create_order_ph_airportvl') }}</option>
                    <option value="Б" {{$order->airport_ukraine == 'Б' ? 'selected' : null}} class="borispol" data-air="B">Борисполь</option>
                    <option value="Ж" {{$order->airport_ukraine == 'Ж' ? 'selected' : null}} class="zhulyany" data-air="J">Жуляны</option>
				</select>

				@if ($errors->has('airport_ukraine'))
					<span class="help-block">
						<strong>{{ $errors->first('airport_ukraine') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>

	<div class="col-sm-3">
		<div id="terminalvl" class="form-group airportvl-info has-feedback {{ $errors->has('terminal') ? ' has-error ' : '' }}">
			{!! Form::label('terminal', trans('forms.create_order_label_terminal'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control" name="terminal" id="terminal">
                    @if($order->airport_ukraine == 'Б')
                        <option value="D" {{$order->terminal == 'D' ? 'selected' : null}}>D</option>
                        <option value="F" {{$order->terminal == 'F' ? 'selected' : null}}>F</option>
                    @endif
				</select>

				@if ($errors->has('terminal'))
					<span class="help-block">
						<strong>{{ $errors->first('terminal') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-3" style="display: none;">
		<div class="form-group has-feedback {{ $errors->has('registration') ? ' has-error ' : '' }}">
			{!! Form::label('registration', trans('forms.create_order_label_registration'), array('class' => 'col-md-12 control-label ')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="registration">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_registration') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('registration', $order->registration, array('id' => 'registration', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_registration'))) !!}
				</div>
				@if ($errors->has('registration'))
					<span class="help-block">
						<strong>{{ $errors->first('registration') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="form-row">
	<div class="col-sm-6">
		<div class="form-group has-feedback {{ $errors->has('address') ? ' has-error ' : '' }}">
			{!! Form::label('address', trans('forms.create_order_label_addressvl'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="address">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_addressvl') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('address', $order->address, array('id' => 'address', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_addressvl'))) !!}
					@if($order->address2 == null)
						<div id="address-caption-hide" class="input-group-prepend btn btn-danger ml-2">
							<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
						</div>
						<div id="address-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: block;">
							<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
						</div>
					@else
						<div id="address-caption-hide" class="input-group-prepend btn btn-danger ml-2" style="display: block;">
							<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
						</div>
						<div id="address-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: none;">
							<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
						</div>
					@endif
				</div>
				<span class="info-block d-none">
					<small>Пример адреса: г. Черкассы, ул. Смелянская 34, п.3</small>
				</span>
				@if ($errors->has('address'))
					<span class="help-block">
						<strong>{{ $errors->first('address') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group has-feedback {{ $errors->has('transfer') ? ' has-error ' : '' }}">
			{!! Form::label('transfer', trans('forms.create_order_label_transfer'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control" name="transfer" id="transfer">
					<option value="">{{ trans('forms.create_order_ph_transfer') }}</option>
					<option value="group" {{$order->transfer == 'group' ? 'selected' : null}}>Групповой</option>
					<option value="individual" {{$order->transfer == 'individual' ? 'selected' : null}}>Индивидуальный</option>
				</select>

				@if ($errors->has('transfer'))
					<span class="help-block">
						<strong>{{ $errors->first('transfer') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="form-row">
	<div class="col-sm-6">
		<div class="form-group has-feedback {{ $errors->has('transfer_type_auto') ? ' has-error ' : '' }}">
			{!! Form::label('address', trans('forms.create_order_label_transfer_type_auto'), array('class' => 'col-md-12 control-label')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control" name="transfer_type_auto" id="transfer_type_auto">
					<option value="">{{ trans('forms.create_order_ph_transfer_type_auto') }}</option>
				</select>

				@if ($errors->has('transfer_type_auto'))
					<span class="help-block"><strong>{{ $errors->first('transfer_type_auto') }}</strong></span>
				@endif
			</div>
		</div>
	</div>
</div>

@if($order->address2 == null)
<div class="form-row hidden-address">
@else
<div class="form-row hidden-address" style="display: flex;">
@endif
	<div class="col-sm-6">
		<div class="form-group has-feedback {{ $errors->has('address2') ? ' has-error ' : '' }}">
			{!! Form::label('address2', trans('forms.create_order_label_addressvl'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="address2">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_addressvl') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::text('address2', $order->address2, array('id' => 'address2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_addressvl'))) !!}
				</div>
				<span class="info-block d-none">
					<small>Пример адреса: г. Черкассы, ул. Смелянская 34, п.3</small>
				</span>
				@if ($errors->has('address2'))
					<span class="help-block">
						<strong>{{ $errors->first('address2') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="form-row">
	<div class="col-sm-3">
		<div class="form-group has-feedback {{ $errors->has('tickets') ? ' has-error ' : '' }}">
			{!! Form::label('tickets', trans('forms.create_order_label_tickets'), array('class' => 'col-md-12 control-label required')); !!}
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="tickets">
							<i class="fa fa-fw {{ trans('forms.create_order_icon_tickets') }}" aria-hidden="true"></i>
						</label>
					</div>
					{!! Form::number('tickets', $order->tickets, array('id' => 'tickets', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_tickets'))) !!}
				</div>
				@if ($errors->has('tickets'))
					<span class="help-block">
						<strong>{{ $errors->first('tickets') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group has-feedback {{ $errors->has('children') ? ' has-error ' : '' }}">
			{!! Form::label('children', trans('forms.create_order_label_children'), array('class' => 'col-md-12 control-label')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control childrenvl-select" name="children" id="children">
					<option value="" class="children_no">нет</option>
					<option value="1" class="children_yes" {{$order->children == 1 ? 'selected' : null}}>1</option>
					<option value="2" class="children_yes" {{$order->children == 2 ? 'selected' : null}}>2</option>
					<option value="3" class="children_yes" {{$order->children == 3 ? 'selected' : null}}>3</option>
					<option value="4" class="children_yes" {{$order->children == 4 ? 'selected' : null}}>4</option>
					<option value="5" class="children_yes" {{$order->children == 5 ? 'selected' : null}}>5</option>
				</select>

				@if ($errors->has('children'))
					<span class="help-block">
						<strong>{{ $errors->first('children') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>

	<div class="col-sm-2">
		<div id="childrenvl" class="childrenvl-info form-group has-feedback {{ $errors->has('ticket_child') ? ' has-error ' : '' }}">
			{!! Form::label('ticket_child', trans('forms.create_order_label_ticket_child'), array('class' => 'col-md-12 control-label')); !!}
			<div class="col-md-12">

				<select class="custom-select form-control" name="ticket_child" id="ticket_child">
					<option value="">0</option>
					<option value="1" {{$order->ticket_child == 1 ? 'selected' : null}}>1</option>
					<option value="2" {{$order->ticket_child == 2 ? 'selected' : null}}>2</option>
					<option value="3" {{$order->ticket_child == 3 ? 'selected' : null}}>3</option>
					<option value="4" {{$order->ticket_child == 4 ? 'selected' : null}}>4</option>
					<option value="5" {{$order->ticket_child == 5 ? 'selected' : null}}>5</option>
				</select>

				@if ($errors->has('ticket_child'))
					<span class="help-block">
						<strong>{{ $errors->first('ticket_child') }}</strong>
					</span>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="form-group has-feedback {{ $errors->has('options') ? ' has-error ' : '' }}">
    {!! Form::label('options', trans('forms.create_order_label_options'), array('class' => 'col-md-12 control-label')); !!}
    <div class="col-md-4">
        <div class="custom-control custom-checkbox" for="option_babyk_vl">
            <input name="option_babyk" class="custom-control-input" id="option_babyk_vl"
                   value="1"
                   {{$order->option_babyk ? 'checked' : null}}
                   type="checkbox">
            <label class="custom-control-label" for="option_babyk_vl">{!! trans('forms.create_order_checkbox_option_babyk') !!}</label>
        </div>
        <div class="custom-control custom-checkbox" for="option_babyl_vl">
            <input name="option_babyl" class="custom-control-input" id="option_babyl_vl"
                   value="1"
                   {{$order->option_babyl ? 'checked' : null}}
                   type="checkbox">
            <label class="custom-control-label" for="option_babyl_vl">{!! trans('forms.create_order_checkbox_option_babyl') !!}</label>
        </div>
    </div>
</div>

<div class="form-group has-feedback {{ $errors->has('info') ? ' has-error ' : '' }}">
    {!! Form::label('info', trans('forms.create_order_label_info') , array('class' => 'col-12 control-label')); !!}
    <div class="col-12">
        {!! Form::textarea('info', $order->info, array('id' => 'info', 'class' => 'form-control', 'rows' => '4', 'placeholder' => trans('forms.create_order_ph_info'))) !!}
        <span class="glyphicon glyphicon-pencil form-control-feedback" aria-hidden="true"></span>
        @if ($errors->has('info'))
            <span class="help-block">
			<strong>{{ $errors->first('info') }}</strong>
		</span>
        @endif
    </div>
</div>

<div class="form-group has-feedback {{ $errors->has('options') ? ' has-error ' : '' }}">
	{!! Form::label('options', trans('forms.create_order_label_status_pay'), array('class' => 'col-md-12 control-label')); !!}
	<div class="col-md-12">
		<div class="custom-control custom-radio" for="status_pay_not_paid">
			<input type="radio" name="status_pay"  class="custom-control-input statusPay_vl" id="status_pay_not_paid" value="not-paid" @if((!is_null($order) && $order->status_pay == 'not-paid') || is_null($order)) checked @endif >
			<label class="custom-control-label" for="status_pay_not_paid">{!! trans('forms.create_order_radio_not_paid') !!}</label>
		</div>
		<div class="custom-control custom-radio" for="status_pay_pay">
			<input type="radio" name="status_pay"  class="custom-control-input statusPay_vl" id="status_pay_pay" value="paid" @if((!is_null($order) && $order->status_pay == 'paid') || is_null($order)) checked @endif >
			<label class="custom-control-label" for="status_pay_pay">{!! trans('forms.create_order_radio_pay') !!}</label>
		</div>
	</div>
</div>

@if($order->status_pay == 'not-paid')
	<div id="else-statusPay_vl" class="form-group hidden_vl has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
@else($order->status_pay == 0)
	<div id="else-statusPay_vl" class="form-group has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
@endif

	{!! Form::label('ticketfree_reason', trans('forms.create_order_label_ticketfree_reason'), array('class' => 'col-md-12 control-label')); !!}
	<div class="col-md-12">
		<div class="custom-control custom-radio" for="customerpaid_vl">
			<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="customerpaid_vl" value="customerpaid" @if((!is_null($order) && $order->ticketfree_reason == 'customerpaid') || is_null($order)) checked @endif >
			<label class="custom-control-label" for="customerpaid_vl">{!! trans('forms.create_order_radio_customerpaid') !!}</label>
		</div>
		@if(Auth::user()->partners_level == '1')
			<div class="custom-control custom-radio" for="cardpersonal_vl">
				<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardpersonal_vl" value="cardpersonal" @if((!is_null($order) && $order->ticketfree_reason == 'cardpersonal') || is_null($order)) checked @endif >
				<label class="custom-control-label" for="cardpersonal_vl">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
			</div>
			@if($showCardGold)
				<div class="custom-control custom-radio" for="cardgold_vl">
					<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardgold_vl" value="cardgold" @if((!is_null($order) && $order->ticketfree_reason == 'cardgold') || is_null($order)) checked @endif >
					<label class="custom-control-label" for="cardgold_vl">{!! trans('forms.create_order_radio_cardgold') !!}</label>
				</div>
			@endif
		@elseif(Auth::user()->partners_level == '2')
			<div class="custom-control custom-radio" for="cardpersonal_vl">
				<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardpersonal_vl" value="cardpersonal" @if((!is_null($order) && $order->ticketfree_reason == 'cardpersonal') || is_null($order)) checked @endif >
				<label class="custom-control-label" for="cardpersonal_vl">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
			</div>
		@elseif(Auth::user()->partners_level == '3')
			@if($showDiscountHalf)
				<div class="custom-control custom-radio" for="discounthalf_vl">
					<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="discounthalf_vl" value="discounthalf" @if((!is_null($order) && $order->ticketfree_reason == 'discounthalf') || is_null($order)) checked @endif >
					<label class="custom-control-label" for="discounthalf_vl">{!! trans('forms.create_order_radio_discounthalf') !!}</label>
				</div>
			@endif
		@else

		@endif
	</div>
</div>

<div class="row align-items-center">
	<div class="col"></div>
	<div class="col-auto">
		<div class="d-sm-inline-block mr-1">Стоимость трансфера: <b><span id="calculated_value_vl"></span> грн.</b></div>
		{!! Form::button(trans('forms.create_order_button_text'), array(
			'class' => 'btn btn-success px-4 ml-2',
			'type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave',
			'data-title' => trans('modals.edit_user__modal_text_confirm_title'),
			'data-message' => trans('modals.edit_user__modal_text_confirm_message')))
		!!}
	</div>
</div>




{!! Form::close() !!}