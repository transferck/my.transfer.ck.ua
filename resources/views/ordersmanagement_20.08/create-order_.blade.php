@extends('layouts.app')

@section('template_title')
    {!! trans('ordersmanagement.create-new-order') !!}
@endsection

@section('template_linked_css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">
@endsection

@section('template_fastload_css')
	.help-block {
		font-size: 12px;
	}
	.control-label{
		font-weight: 700;
	}
	.hidden {
		display: none !important;
	}	

	.hidden_vl {
		display: none !important;
	}	
	
	.hidden_pr {
		display: none !important;
	}	
	
	#p-caption-hide {
		display: none;
	}	
	
	#address-caption-hide {
		display: none;
	}	
	
	#pr-caption-hide {
		display: none;
	}		
	.hidden-area {
		display: none;
	}	
	.hidden-address {
		display: none;
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
@endsection

@section('content')

    <div class="container">
        <div class="row">
			<div class="col-lg-10 offset-lg-1">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item"><a class="vl icons-table nav-link active" id="home-tab" data-toggle="tab" href="#tab-home" role="tab" aria-controls="tab-home" aria-selected="true">{!! trans('ordersmanagement.create-new-ordervl') !!}</a></li>
					<li class="nav-item"><a class="pr icons-table nav-link" id="profile-tab" data-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile" aria-selected="false">{!! trans('ordersmanagement.create-new-orderpr') !!}</a></li>
				</ul>
				<div class="tab-content border-x mt-3 border-bottom" id="myTabContent">
					<div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
						<div class="card" id="vilet">
							{!! Form::open(array('route' => 'orders.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
							{!! csrf_field() !!}
							<div class="card-body">
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
													{!! Form::text('fio', NULL, array('id' => 'fio', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
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
													{!! Form::text('phone', NULL, array('id' => 'phone', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
													<div id="p-caption-hide" class="input-group-prepend btn btn-danger ml-2">
														<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
													</div>
													<div id="p-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: block;">
														<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
													</div>
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

								<div class="form-row hidden-area">
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
													{!! Form::text('fio2', NULL, array('id' => 'fio2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
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
													{!! Form::text('phone2', NULL, array('id' => 'phone2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
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
									<div class="col-sm-4">
										<div class="form-group has-feedback {{ $errors->has('datetime') ? ' has-error ' : '' }}">
											{!! Form::label('datetime', trans('forms.create_order_label_datetimevl'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="datetime">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_datetimevl') }}" aria-hidden="true"></i>
														</label>
													</div>												
													{!! Form::text('datetime', NULL, array('id' => 'datetime', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('forms.create_order_ph_datetimevl'))) !!}
												</div>
												@if ($errors->has('datetime'))
													<span class="help-block">
														<strong>{{ $errors->first('datetime') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>							
									<div class="col-sm-3">
										<div class="form-group has-feedback {{ $errors->has('airport_ukraine') ? ' has-error ' : '' }}">
											{!! Form::label('airport_ukraine', trans('forms.create_order_label_airportvl'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												{!! Form::select('airport_ukraine',  array('Б' => 'Борисполь', 'Ж' => 'Жуляны'), 'null', ['placeholder' => 'Не выбран', 'id' => 'airport_ukraine_vl', 'class' => 'custom-select form-control airportvl-select']) !!}	
												@if ($errors->has('airport_ukraine'))
													<span class="help-block">
														<strong>{{ $errors->first('airport_ukraine') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>		

									<div class="col-sm-3">
										<div class="form-group has-feedback {{ $errors->has('terminal') ? ' has-error ' : '' }}">
											{!! Form::label('terminal', trans('forms.create_order_label_terminal'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												{!! Form::select('terminal',  array('D' => 'D', 'F' => 'F'), 'null', ['placeholder' => 'Не выбран', 'id' => 'terminal_vl', 'class' => 'custom-select form-control']) !!}
												@if ($errors->has('terminal'))
													<span class="help-block">
														<strong>{{ $errors->first('terminal') }}</strong>
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
													{!! Form::text('address', NULL, array('id' => 'address', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_addressvl'))) !!}
													<div id="address-caption-hide" class="input-group-prepend btn btn-danger ml-2">
														<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
													</div>
													<div id="address-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: block;">
														<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
													</div>
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
												{!! Form::select('transfer',  array('group' => 'Групповой', 'individual' => 'Индивидуальный'), 'null', ['placeholder' => 'Не выбран', 'class' => 'custom-select form-control']) !!}						 
												@if ($errors->has('transfer'))
													<span class="help-block">
														<strong>{{ $errors->first('transfer') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>
								</div>
								<div class="form-row hidden-address">
									<div class="col-sm-6">
										<div class="form-group has-feedback {{ $errors->has('address2') ? ' has-error ' : '' }}">
											{!! Form::label('address2', trans('forms.create_order_label_addressvl'), array('class' => 'col-md-12 control-label')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="address2">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_addressvl') }}" aria-hidden="true"></i>
														</label>
													</div>
													{!! Form::text('address2', NULL, array('id' => 'address2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_addressvl'))) !!}
												</div>
												@if ($errors->has('address2'))
													<span class="help-block">
														<strong>{{ $errors->first('address2') }}</strong>
													</span>
												@endif
											</div>
										</div>									
									</div>
								</div>
								
								<div class="form-row mb-4">
									<div class="col-sm-3">
										<div class="form-group has-feedback {{ $errors->has('tickets') ? ' has-error ' : '' }}">
											{!! Form::label('tickets', trans('forms.create_order_label_tickets'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-10">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="tickets">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_tickets') }}" aria-hidden="true"></i>
														</label>
													</div>
													{!! Form::number('tickets', '1', array('id' => 'tickets', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_tickets'))) !!}
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
												{!! Form::select('children',  array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'null', ['placeholder' => 'Нет', 'id' => 'children_vl', 'class' => 'custom-select form-control']) !!}										
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

												{!! Form::select('ticket_child',  array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'null', ['placeholder' => '0', 'class' => 'custom-select form-control']) !!}
												@if ($errors->has('ticket_child'))
													<span class="help-block">
														<strong>{{ $errors->first('ticket_child') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>										
								</div>
								<small class="ml-3" style="margin-top: -2rem !important;position: absolute;">{!! trans('forms.create_order_small_ticket_child') !!}</small>
								
								<div class="form-group has-feedback {{ $errors->has('options') ? ' has-error ' : '' }}">
									{!! Form::label('options', trans('forms.create_order_label_options'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-6">
										<label class="custom-control custom-checkbox" for="option_babyk_vl">
											{!! Form::checkbox('option_babyk',  '1', false, ['id' => 'option_babyk_vl', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_babyk_vl">{!! trans('forms.create_order_checkbox_option_babyk') !!}</label>
										</label>								
										<label class="custom-control custom-checkbox" for="option_babyl_vl">
											{!! Form::checkbox('option_babyl',  '1', false, ['id' => 'option_babyl_vl', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_babyl_vl">{!! trans('forms.create_order_checkbox_option_babyl') !!}</label>
										</label>
										<label class="custom-control custom-checkbox d-none" for="option_suburb_vl">
											{!! Form::checkbox('suburb',  '1', false, ['id' => 'option_suburb_vl', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_suburb_vl">{!! trans('forms.create_order_checkbox_option_suburb') !!}</label>
										</label>										
									</div>
									<small class="ml-3">{!! trans('forms.create_order_small_options_vl') !!}</small>
								</div>								
								
								<div class="form-group has-feedback {{ $errors->has('info') ? ' has-error ' : '' }}">
									{!! Form::label('info', trans('forms.create_order_label_info') , array('class' => 'col-12 control-label')); !!}
									<div class="col-12">
										{!! Form::textarea('info', old('info'), array('id' => 'info', 'class' => 'form-control', 'rows' => '4', 'placeholder' => trans('forms.create_order_ph_info'))) !!}
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
										<div class="custom-control custom-radio" for="status_pay_not_paid_vl">
											{!! Form::radio('status_pay',  'not-paid', true, ['id' => 'status_pay_not_paid_vl', 'class' => 'custom-control-input statusPay_vl']) !!}
											<label class="custom-control-label" for="status_pay_not_paid_vl">{!! trans('forms.create_order_radio_not_paid') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="status_pay_vl">
											{!! Form::radio('status_pay',  'paid', false, ['id' => 'status_pay_vl', 'class' => 'custom-control-input statusPay_vl']) !!}
											<label class="custom-control-label" for="status_pay_vl">{!! trans('forms.create_order_radio_pay') !!}</label>
										</div>
									</div>
								</div>	

								<div id="else-statusPay_vl" class="form-group hidden_vl has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
									{!! Form::label('ticketfree_reason', trans('forms.create_order_label_ticketfree_reason'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-12">
										<div class="custom-control custom-radio" for="customerpaid_vl">
											{!! Form::radio('ticketfree_reason',  'customerpaid', true, ['id' => 'customerpaid_vl', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="customerpaid_vl">{!! trans('forms.create_order_radio_customerpaid') !!}</label>
										</div>
										@if(Auth::user()->partners_level == '1')
											<div class="custom-control custom-radio" for="cardpersonal_vl">
												{!! Form::radio('ticketfree_reason',  'cardpersonal', false, ['id' => 'cardpersonal_vl', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardpersonal_vl">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
											</div>
											<div class="custom-control custom-radio" for="cardgold_vl">
												{!! Form::radio('ticketfree_reason',  'cardgold', false, ['id' => 'cardgold_vl', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardgold_vl">{!! trans('forms.create_order_radio_cardgold') !!}</label>
											</div>
										@elseif(Auth::user()->partners_level == '2')
											<div class="custom-control custom-radio" for="cardpersonal_vl">
												{!! Form::radio('ticketfree_reason',  'cardpersonal', false, ['id' => 'cardpersonal_vl', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardpersonal_vl">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
											</div>
										@elseif(Auth::user()->partners_level == '3')	
											<div class="custom-control custom-radio" for="discounthalf_vl">
												{!! Form::radio('ticketfree_reason',  'discounthalf', false, ['id' => 'discounthalf_vl', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="discounthalf_vl">{!! trans('forms.create_order_radio_discounthalf') !!}</label>
											</div>	
										@else
											
										@endif																	
									</div>
								</div>
							</div>
							<div class="card-footer border-top">
								<div class="row align-items-center">
									<div class="col"></div>
									<div class="col-auto">
										<div class="d-sm-inline-block mr-1">{!! trans('forms.create_order_price_calculated') !!}: <b><span id="calculated_value_vl"></span> грн.</b></div>
										{!! Form::button(trans('forms.create_order_button_text'), array('class' => 'btn btn-success px-4 ml-2','type' => 'submit' )) !!}
										{!! Form::close() !!}										
									</div>
								</div>
							</div>	
						</div>
					</div>
					<div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="card" id="prilet">
							{!! Form::open(array('route' => 'order.store_pr', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
							{!! csrf_field() !!}						
							<div class="card-body">
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
													{!! Form::text('fio', NULL, array('id' => 'fio', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
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
													{!! Form::text('phone', NULL, array('id' => 'phone', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
													<div id="pr-caption-hide" class="input-group-prepend btn btn-danger ml-2">
														<i aria-hidden="true" class="fa fa-fw fa-minus-square"></i>
													</div>
													<div id="pr-caption-display" class="input-group-prepend btn btn-success ml-2" style="display: block;">
														<i aria-hidden="true" class="fa fa-fw fa-plus-square"></i>
													</div>									
												</div>
												@if ($errors->has('phone'))
													<span class="help-block">
														<strong>{{ $errors->first('phone') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>							
								</div>			
								<div class="form-row hidden-area">
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
													{!! Form::text('fio2', NULL, array('id' => 'fio2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_fio'))) !!}
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
													{!! Form::text('phone2', NULL, array('id' => 'phone2', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_phone'))) !!}
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
									<div class="col-sm-4">
										<div class="form-group has-feedback {{ $errors->has('datetime') ? ' has-error ' : '' }}">
											{!! Form::label('datetime', trans('forms.create_order_label_datetimepr'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="datetime">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_datetimepr') }}" aria-hidden="true"></i>
														</label>
													</div>
													{!! Form::text('datetime', NULL, array('id' => 'datetime', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_datetimepr'))) !!}
												</div>
												@if ($errors->has('datetime'))
													<span class="help-block">
														<strong>{{ $errors->first('datetime') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group has-feedback {{ $errors->has('airport_ukraine') ? ' has-error ' : '' }}">
											{!! Form::label('airport_ukraine', trans('forms.create_order_label_airportpr'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												{!! Form::select('airport_ukraine',  array('Б' => 'Борисполь', 'Ж' => 'Жуляны'), 'null', ['placeholder' => 'Не выбран', 'id' => 'airport_ukraine_pr', 'class' => 'custom-select form-control airportpr-select']) !!}	
												@if ($errors->has('airport_ukraine'))
													<span class="help-block">
														<strong>{{ $errors->first('airport_ukraine') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>		

									<div class="col-sm-4">
										<div class="form-group has-feedback {{ $errors->has('terminal') ? ' has-error ' : '' }}">
											{!! Form::label('terminal', trans('forms.create_order_label_terminal'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												{!! Form::select('terminal',  array('D' => 'D', 'F' => 'F'), 'null', ['placeholder' => 'Не выбран', 'id' => 'terminal_pr', 'class' => 'custom-select form-control']) !!}
												@if ($errors->has('terminal'))
													<span class="help-block">
														<strong>{{ $errors->first('terminal') }}</strong>
													</span>
												@endif
											</div>
										</div>									
									</div>							
								</div>

								<div class="form-row">
									<div class="col-sm-6">
										<div class="form-group has-feedback {{ $errors->has('airport_world') ? ' has-error ' : '' }}">
											{!! Form::label('airport_world', trans('forms.create_order_label_airport_world'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="airport_world">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_airport_world') }}" aria-hidden="true"></i>
														</label>
													</div>
													{!! Form::text('airport_world', NULL, array('id' => 'airport_world', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_airport_world'))) !!}
												</div>
												@if ($errors->has('airport_world'))
													<span class="help-block">
														<strong>{{ $errors->first('airport_world') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group has-feedback {{ $errors->has('flight') ? ' has-error ' : '' }}">
											{!! Form::label('flight', trans('forms.create_order_label_flight'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="flight">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_flight') }}" aria-hidden="true"></i>
														</label>
													</div>										
													{!! Form::text('flight', NULL, array('id' => 'flight', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_flight'))) !!}
												</div>
												@if ($errors->has('flight'))
													<span class="help-block">
														<strong>{{ $errors->first('flight') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>
								</div>		
												
								<div class="form-row">
									<div class="col-sm-6">
										<div class="form-group has-feedback {{ $errors->has('address') ? ' has-error ' : '' }}">
											{!! Form::label('address', trans('forms.create_order_label_addresspr'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
												{!! Form::select('address',  array('cherkasy' => 'Черкассы', 'zolotonosha' => 'Золотоноша'), 'null', ['placeholder' => 'Не выбран', 'id' => 'address', 'class' => 'custom-select form-control']) !!}
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
												{!! Form::select('transfer',  array('group' => 'Групповой', 'individual' => 'Индивидуальный'), 'null', ['placeholder' => 'Не выбран', 'class' => 'custom-select form-control']) !!}
												@if ($errors->has('transfer'))
													<span class="help-block">
														<strong>{{ $errors->first('transfer') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>					
								</div>	
								
								<div class="form-row mb-4">	
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
													{!! Form::number('tickets', '1', array('id' => 'tickets', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_tickets'))) !!}
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
												{!! Form::select('children',  array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'null', ['placeholder' => 'Нет', 'id' => 'children_pr', 'class' => 'custom-select form-control childrenpr-select']) !!}		
												@if ($errors->has('children'))
													<span class="help-block">
														<strong>{{ $errors->first('children') }}</strong>
													</span>
												@endif
											</div>
										</div>
									</div>
										
									<div class="col-sm-2">
										<div id="childrenpr" class="childrenpr-info form-group has-feedback {{ $errors->has('ticket_child') ? ' has-error ' : '' }}">
											{!! Form::label('ticket_child', trans('forms.create_order_label_ticket_child'), array('class' => 'col-md-12 control-label')); !!}
											<div class="col-md-12">
												{!! Form::select('ticket_child',  array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), 'null', ['placeholder' => '0', 'class' => 'custom-select form-control']) !!}
												@if ($errors->has('ticket_child'))
													<span class="help-block">
														<strong>{{ $errors->first('ticket_child') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>																
								</div>
								<small class="ml-3" style="margin-top: -2rem !important;position: absolute;">{!! trans('forms.create_order_small_ticket_child') !!}</small>
								
								<div class="form-group has-feedback {{ $errors->has('options') ? ' has-error ' : '' }}">
									{!! Form::label('options', trans('forms.create_order_label_options'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-6">
										<div class="custom-control custom-checkbox" for="option_nameplate_pr">
											{!! Form::checkbox('option_nameplate',  '1', false, ['id' => 'option_nameplate_pr', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_nameplate_pr">{!! trans('forms.create_order_checkbox_option_nameplate') !!}</label>
										</div>
										<div class="custom-control custom-checkbox" for="option_babyk_pr">
											{!! Form::checkbox('option_babyk',  '1', false, ['id' => 'option_babyk_pr', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_babyk_pr">{!! trans('forms.create_order_checkbox_option_babyk') !!}</label>
										</div>
										<div class="custom-control custom-checkbox" for="option_babyl_pr">
											{!! Form::checkbox('option_babyl',  '1', false, ['id' => 'option_babyl_pr', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_babyl_pr">{!! trans('forms.create_order_checkbox_option_babyl') !!}</label>
										</div>
										<div class="custom-control custom-checkbox d-none" for="option_suburb_pr">
											{!! Form::checkbox('suburb',  '1', false, ['id' => 'option_suburb_pr', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="option_suburb_pr">{!! trans('forms.create_order_checkbox_option_suburb') !!}</label>
										</div>										
									</div>
									<small class="ml-3">{!! trans('forms.create_order_small_options_pr') !!}</small>
								</div>	
								
								<div class="form-group has-feedback {{ $errors->has('info') ? ' has-error ' : '' }}">
									{!! Form::label('info', trans('forms.create_order_label_info') , array('class' => 'col-12 control-label')); !!}
									<div class="col-12">
										{!! Form::textarea('info', old('info'), array('id' => 'info', 'class' => 'form-control', 'rows' => '4', 'placeholder' => trans('forms.create_order_ph_info'))) !!}
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
										<div class="custom-control custom-radio" for="status_pay_not_paid_pr">
											{!! Form::radio('status_pay',  'not-paid', true, ['id' => 'status_pay_not_paid_pr', 'class' => 'custom-control-input statusPay_pr']) !!}
											<label class="custom-control-label" for="status_pay_not_paid_pr">{!! trans('forms.create_order_radio_not_paid') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="status_pay_pr">
											{!! Form::radio('status_pay',  'paid', false, ['id' => 'status_pay_pr', 'class' => 'custom-control-input statusPay_pr']) !!}
											<label class="custom-control-label" for="status_pay_pr">{!! trans('forms.create_order_radio_pay') !!}</label>
										</div>
									</div>
								</div>						
									
								<div id="else-statusPay_pr" class="form-group hidden_pr has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
									{!! Form::label('ticketfree_reason', trans('forms.create_order_label_ticketfree_reason'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-12">
										<div class="custom-control custom-radio" for="customerpaid_pr">
											{!! Form::radio('ticketfree_reason',  'customerpaid', true, ['id' => 'customerpaid_pr', 'class' => 'custom-control-input']) !!}
											<label class="custom-control-label" for="customerpaid_pr">{!! trans('forms.create_order_radio_customerpaid') !!}</label>
										</div>
										@if(Auth::user()->partners_level == '1')
											<div class="custom-control custom-radio" for="cardpersonal_pr">
												{!! Form::radio('ticketfree_reason',  'cardpersonal', false, ['id' => 'cardpersonal_pr', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardpersonal_pr">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
											</div>
											<div class="custom-control custom-radio" for="cardgold_pr">
												{!! Form::radio('ticketfree_reason',  'cardgold', false, ['id' => 'cardgold_pr', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardgold_pr">{!! trans('forms.create_order_radio_cardgold') !!}</label>
											</div>
										@elseif(Auth::user()->partners_level == '2')
											<div class="custom-control custom-radio" for="cardpersonal_pr">
												{!! Form::radio('ticketfree_reason',  'cardpersonal', false, ['id' => 'cardpersonal_pr', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="cardpersonal_pr">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
											</div>
										@elseif(Auth::user()->partners_level == '3')	
											<div class="custom-control custom-radio" for="discounthalf_pr">
												{!! Form::radio('ticketfree_reason',  'discounthalf', false, ['id' => 'discounthalf_pr', 'class' => 'custom-control-input']) !!}
												<label class="custom-control-label" for="discounthalf_pr">{!! trans('forms.create_order_radio_discounthalf') !!}</label>
											</div>	
										@else
											
										@endif																	
									</div>									
								</div>
							</div>
							<div class="card-footer border-top">
								<div class="row align-items-center">
									<div class="col"></div>
									<div class="col-auto">
										<div class="d-sm-inline-block mr-1">{!! trans('forms.create_order_price_calculated') !!}: <b><span id="calculated_value_pr"></span> грн.</b></div>
										{!! Form::button(trans('forms.create_order_button_text'), array('class' => 'btn btn-success px-4 ml-2','type' => 'submit' )) !!}
										{!! Form::close() !!}										
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer_scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('js/flatpickr.min.js')}}"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

	<script>
        $(function () {
			var statusPay_vl = $('.statusPay_vl');
			var statusPay_pr = $('.statusPay_pr');

            statusPay_vl.change(function () {
                if ($(this).val() === 'paid') {
                    $('#else-statusPay_vl').removeClass('hidden_vl');
                } else {
                    $('#else-statusPay_vl').addClass('hidden_vl');
                }
            });		

            statusPay_pr.change(function () {
                if ($(this).val() === 'paid') {
                    $('#else-statusPay_pr').removeClass('hidden_pr');
                } else {
                    $('#else-statusPay_pr').addClass('hidden_pr');
                }
            });

			var vlCalc = {
				selectEl: '#airport_ukraine_vl',
				ticketsEl: '#vilet #tickets',
				childTicketsEl: '#vilet #ticket_child',
				resultEl: '#calculated_value_vl',
				suburbEl: '#option_suburb_vl',

				bonusEl: {
					personal: '#cardpersonal_vl',
					gold: '#cardgold_vl',
				},

				data: {
					calculatedValue: null,
					elements: {
						select: '',
						tickets: 0,
						childTickets: 0,
						suburb: false,
						bonus: {
							personal: false,
							gold: false,
						}
					},
					coefs: {
						B: {
							adult: 300,
							child: 270,
						},
						ZH: {
							adult: 350,
							child: 320,
						},
					},
				},

				elements: {
					select: null,
					tickets: null,
					childTickets: null,
					result: null,
					suburb: null,
					bonus: {
						personal: null,
						gold: null,
					}
				},

				init: function () {
					this.elements.select = $(this.selectEl);
					this.elements.tickets = $(this.ticketsEl);
					this.elements.childTickets = $(this.childTicketsEl);
					this.elements.result = $(this.resultEl);
					this.elements.suburb = $(this.suburbEl);
					this.elements.bonus.personal = $(this.bonusEl.personal);
					this.elements.bonus.gold = $(this.bonusEl.gold);

					this.data.elements.tickets = +this.elements.tickets.val();

					this.initHandlers();
				},

				initHandlers: function () {
					var self = this;

					this.elements.select.change(function (event) {
						this.data.elements.select = event.target.value;

						this.calcValue();
					}.bind(this));

					this.elements.tickets.on('change', function (event) {
						this.data.elements.tickets = +event.target.value;

						this.calcValue();
					}.bind(this));

					this.elements.childTickets.change(function (event) {
						this.data.elements.childTickets = +event.target.value;

						this.calcValue();
					}.bind(this));

					this.elements.suburb.change(function () {
						self.data.elements.suburb = $(this).is(":checked");

						self.calcValue();
					});
				},

				calcValue: function () {
					if (this.data.elements.select) {
						var selectVal = '',
							result = 0;
						if (this.data.elements.select === 'Б') selectVal = 'B';
						if (this.data.elements.select === 'Ж') selectVal = 'ZH';

						if (this.data.elements.tickets && this.data.elements.tickets >= 0) {
							result += this.data.elements.tickets *
									this.data.coefs[selectVal].adult;
						}

						if (this.data.elements.childTickets && this.data.elements.childTickets >= 0)
							result += this.data.elements.childTickets *
									this.data.coefs[selectVal].child;

						if (this.data.elements.suburb)
							result += 100;

						this.data.calculatedValue = result;
					}

					if (this.data.elements.tickets + this.data.elements.childTickets !== 1) {
						this.elements.bonus.personal.prop('checked', false);
						this.elements.bonus.gold.prop('checked', false);

						this.elements.bonus.personal.parent().addClass('disabled');
						this.elements.bonus.gold.parent().addClass('disabled');
					} else {
						this.elements.bonus.personal.parent().removeClass('disabled');
						this.elements.bonus.gold.parent().removeClass('disabled');
					}

					this.renderResult();
				},

				renderResult: function () {
					if (this.data.calculatedValue !== null &&
							this.data.calculatedValue >= 0)
						this.elements.result.text(this.data.calculatedValue);
					else
						this.elements.result.text();
				},
			};

			vlCalc.init();

			var prCalc = {
				selectEl: '#airport_ukraine_pr',
				ticketsEl: '#prilet #tickets',
				childTicketsEl: '#prilet #ticket_child',
				resultEl: '#calculated_value_pr',
				nameplateEl: '#option_nameplate_pr',
				transferEl: '#prilet #transfer',
				suburbEl: '#option_suburb_pr',

				bonusEl: {
					personal: '#cardpersonal_pr',
					gold: '#cardgold_pr',
					discounthalf: '#discounthalf_pr',
				},

				data: {
					calculatedValue: null,
					elements: {
						select: '',
						tickets: 0,
						childTickets: 0,
						nameplate: false,
						transfer: '',
						suburb: false,
						bonus: {
							personal: false,
							gold: false,
							discounthalf: false,
						}
					},
					coefs: {
						B: {
							adult: 300,
							child: 270,
						},
						ZH: {
							adult: 350,
							child: 320,
						},
					},
				},

				elements: {
					select: null,
					tickets: null,
					childTickets: null,
					result: null,
					nameplate: null,
					transfer: null,
					suburb: null,
					bonus: {
						personal: null,
						gold: null,
						discounthalf: null,
					}
				},

				init: function () {
					this.elements.select = $(this.selectEl);
					this.elements.tickets = $(this.ticketsEl);
					this.elements.childTickets = $(this.childTicketsEl);
					this.elements.result = $(this.resultEl);
					this.elements.nameplate = $(this.nameplateEl);
					this.elements.transfer = $(this.transferEl);
					this.elements.suburb = $(this.suburbEl);
					this.elements.bonus.personal = $(this.bonusEl.personal);
					this.elements.bonus.gold = $(this.bonusEl.gold);
					this.elements.bonus.discounthalf = $(this.bonusEl.discounthalf);

					this.data.elements.tickets = +this.elements.tickets.val();

					this.initHandlers();
				},

				initHandlers: function () {
					var self = this;

					this.elements.select.change(function (event) {
						self.data.elements.select = event.target.value;

						self.calcValue();
					});

					this.elements.tickets.on('change', function (event) {
						self.data.elements.tickets = +event.target.value;

						self.calcValue();
					});

					this.elements.childTickets.change(function (event) {
						self.data.elements.childTickets = +event.target.value;

						self.calcValue();
					});

					this.elements.nameplate.change(function () {
						self.data.elements.nameplate = $(this).is(":checked");

						self.calcValue();
					});

					this.elements.suburb.change(function () {
						self.data.elements.suburb = $(this).is(":checked");

						self.calcValue();
					});

					this.elements.transfer.change(function (event) {
						self.data.elements.transfer = event.target.value;

						if (event.target.value === 'group') {
							self.elements.nameplate.prop('checked', false);
							self.elements.nameplate.attr('disabled', 'disabled');
						} else
							self.elements.nameplate.removeAttr('disabled');
					});
				},

				calcValue: function () {
					if (this.data.elements.select) {
						var selectVal = '',
								result = 0;
						if (this.data.elements.select === 'Б') selectVal = 'B';
						if (this.data.elements.select === 'Ж') selectVal = 'ZH';

						if (this.data.elements.tickets && this.data.elements.tickets >= 0) {
							result += this.data.elements.tickets *
									this.data.coefs[selectVal].adult;
						}

						if (this.data.elements.childTickets && this.data.elements.childTickets >= 0)
							result += this.data.elements.childTickets *
									this.data.coefs[selectVal].child;

						if (this.data.elements.nameplate)
							result += 150;

						if (this.data.elements.suburb)
							result += 100;

						this.data.calculatedValue = result;
					}

					if (this.data.elements.tickets + this.data.elements.childTickets !== 1) {
						this.elements.bonus.personal.prop('checked', false);
						this.elements.bonus.gold.prop('checked', false);
						this.elements.bonus.discounthalf.prop('checked', false);

						this.elements.bonus.personal.parent().addClass('disabled');
						this.elements.bonus.gold.parent().addClass('disabled');
						this.elements.bonus.discounthalf.parent().addClass('disabled');
					} else {
						this.elements.bonus.personal.parent().removeClass('disabled');
						this.elements.bonus.gold.parent().removeClass('disabled');
						this.elements.bonus.discounthalf.parent().removeClass('disabled');
					}

					this.renderResult();
				},

				renderResult: function () {
					if (this.data.calculatedValue !== null &&
							this.data.calculatedValue >= 0)
						this.elements.result.text(this.data.calculatedValue);
					else
						this.elements.result.text();
				},
			};

			prCalc.init();

        });
    </script>

    <script>
		$(function() {
			$("#p-caption-hide").click(function() {
				$(".hidden-area").css("display", "none");
				$("#p-caption-hide").css("display", "none");
				$("#p-caption-display").css("display", "block");
			});

			$("#p-caption-display").click(function() {
				$(".hidden-area").css("display", "flex");
				$("#p-caption-hide").css("display", "block");
				$("#p-caption-display").css("display", "none");
			});
			
			$("#pr-caption-hide").click(function() {
				$(".hidden-area").css("display", "none");
				$("#pr-caption-hide").css("display", "none");
				$("#pr-caption-display").css("display", "block");
			});

			$("#pr-caption-display").click(function() {
				$(".hidden-area").css("display", "flex");
				$("#pr-caption-hide").css("display", "block");
				$("#pr-caption-display").css("display", "none");
			});	

			$("#address-caption-hide").click(function() {
				$(".hidden-address").css("display", "none");
				$("#address-caption-hide").css("display", "none");
				$("#address-caption-display").css("display", "block");
			});

			$("#address-caption-display").click(function() {
				$(".hidden-address").css("display", "flex");
				$("#address-caption-hide").css("display", "block");
				$("#address-caption-display").css("display", "none");
			});
			
		});
    </script>

	<script>
		$('select#airport_ukraine_pr option').each(function(){
			var theText = $(this).html();
			$(this).addClass(theText);
		});

		$('select#airport_ukraine_vl option').each(function(){
			var theText = $(this).html();
			$(this).addClass(theText);
		});

		$('select#children_vl option').each(function(){
			var theText = $(this).html();
			$(this).addClass(theText);
		});

		$('select#children_pr option').each(function(){
			var theText = $(this).html();
			$(this).addClass(theText);
		});
	</script>		
	


	<script>
		flatpickr("#datetime", {
			//minDate: "today",
			locale: "ru",
			enableTime: true,
			dateFormat: "Y-m-d H:i",
			time_24hr: true,
		});

		var terminals = {
			"Б": ["D", "F"]
			//"Ж": ["A", "B", "D"]
		};

		$('#airport_ukraine_vl').change(function(){
			$('#terminal_vl').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal_vl').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

		$('#airport_ukraine_pr').change(function(){
			$('#terminal_pr').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal_pr').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

	</script>
@endsection
