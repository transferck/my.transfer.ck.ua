@extends('layouts.app')

@section('template_title')
    {!! trans('ordersmanagement.create-new-order') !!}
@endsection

@section('template_linked_css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">
@endsection

@section('template_fastload_css')
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
						<div class="card">
							<div class="card-body">
								{!! Form::open(array('route' => 'orders.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

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
									
												<select class="custom-select form-control airportvl-select" name="airport_ukraine" id="airport_ukraine">
													<option value="0">{{ trans('forms.create_order_ph_airportvl') }}</option>
													<option value="Б" class="borispol">Борисполь</option>
													<option value="Ж" class="zhulyany">Жуляны</option>
												</select>
						 
												@if ($errors->has('airport_ukraine'))
													<span class="help-block">
														<strong>{{ $errors->first('airport_ukraine') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>		

									<div class="col-sm-2">
										<div id="terminalvl" class="form-group airportvl-info hidden has-feedback {{ $errors->has('terminal') ? ' has-error ' : '' }}">
											{!! Form::label('terminal', trans('forms.create_order_label_terminal'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
									
												<select class="custom-select form-control" name="terminal" id="terminal">
													<option value="0">{{ trans('forms.create_order_ph_terminal') }}</option>
													<option value="D">D</option>
													<option value="F">F</option>
												</select>
						 
												@if ($errors->has('terminal'))
													<span class="help-block">
														<strong>{{ $errors->first('terminal') }}</strong>
													</span>
												@endif
											</div>
										</div>									
									</div>	
									<div class="col-sm-3">
										<div class="form-group has-feedback {{ $errors->has('registration') ? ' has-error ' : '' }}">
											{!! Form::label('registration', trans('forms.create_order_label_registration'), array('class' => 'col-md-12 control-label ')); !!}
											<div class="col-md-12">
												<div class="input-group">
													<div class="input-group-prepend">
														<label class="input-group-text" for="registration">
															<i class="fa fa-fw {{ trans('forms.create_order_icon_registration') }}" aria-hidden="true"></i>
														</label>
													</div>
													{!! Form::text('registration', NULL, array('id' => 'registration', 'class' => 'form-control', 'placeholder' => trans('forms.create_order_ph_registration'))) !!}
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
									
												<select class="custom-select form-control" name="transfer" id="transfer">
													<option value="">{{ trans('forms.create_order_ph_transfer') }}</option>
													<option value="group">Групповой</option>
													<option value="individual">Индивидуальный</option>
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
								<div class="form-row hidden-address">
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
								
								<div class="form-row">
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

												<select class="custom-select form-control childrenvl-select" name="children" id="children">
													<option value="" class="children_no">нет</option>
													<option value="1" class="children_yes">1</option>
													<option value="2" class="children_yes">2</option>
													<option value="3" class="children_yes">3</option>
													<option value="4" class="children_yes">4</option>
													<option value="5" class="children_yes">5</option>
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
										<div id="childrenvl" class="childrenvl-info hidden form-group has-feedback {{ $errors->has('ticket_child') ? ' has-error ' : '' }}">
											{!! Form::label('ticket_child', trans('forms.create_order_label_ticket_child'), array('class' => 'col-md-12 control-label')); !!}
											<div class="col-md-12">
									
												<select class="custom-select form-control" name="ticket_child" id="ticket_child">
													<option value="">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
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
									<div class="col-md-12">
										<label class="custom-control custom-checkbox" for="option_babyk_vl">
											<input name="option_babyk" class="custom-control-input" id="option_babyk_vl" value="1" type="checkbox"> 
											<label class="custom-control-label" for="option_babyk_vl">{!! trans('forms.create_order_checkbox_option_babyk') !!}</label>
										</label>								
										<label class="custom-control custom-checkbox" for="option_babyl_vl">
											<input name="option_babyl" class="custom-control-input" id="option_babyl_vl" value="1" type="checkbox"> 
											<label class="custom-control-label" for="option_babyl_vl">{!! trans('forms.create_order_checkbox_option_babyl') !!}</label>
										</label>
									</div>
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
										<div class="custom-control custom-radio" for="status_pay_not_paid">
											<input type="radio" name="status_pay"  class="custom-control-input statusPay_vl" id="status_pay_not_paid" value="not-paid" checked>
											<label class="custom-control-label" for="status_pay_not_paid">{!! trans('forms.create_order_radio_not_paid') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="status_pay_pay">
											<input type="radio" name="status_pay"  class="custom-control-input statusPay_vl" id="status_pay_pay" value="paid">
											<label class="custom-control-label" for="status_pay_pay">{!! trans('forms.create_order_radio_pay') !!}</label>
										</div>
									</div>
								</div>	

								<div id="else-statusPay_vl" class="form-group hidden_vl has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
									{!! Form::label('ticketfree_reason', trans('forms.create_order_label_ticketfree_reason'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-12">
										<div class="custom-control custom-radio" for="customerpaid_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="customerpaid_vl" value="customerpaid" checked>
											<label class="custom-control-label" for="customerpaid_vl">{!! trans('forms.create_order_radio_customerpaid') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="cardpersonal_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardpersonal_vl" value="cardpersonal">
											<label class="custom-control-label" for="cardpersonal_vl">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="cardgold_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardgold_vl" value="cardgold">
											<label class="custom-control-label" for="cardgold_vl">{!! trans('forms.create_order_radio_cardgold') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="discountfive_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="discountfive_vl" value="discountfive">
											<label class="custom-control-label" for="discountfive_vl">{!! trans('forms.create_order_radio_discountfive') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="discounthalf_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="discounthalf_vl" value="discounthalf">
											<label class="custom-control-label" for="discounthalf_vl">{!! trans('forms.create_order_radio_discounthalf') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="balance_vl">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="balance_vl" value="balance">
											<label class="custom-control-label" for="balance_vl">{!! trans('forms.create_order_radio_balance') !!}</label>
										</div>									
									</div>
								</div>								
								
								{!! Form::button(trans('forms.create_order_button_text'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="card">
							<div class="card-body">
								{!! Form::open(array('route' => 'order.store_pr', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

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
									
												<select class="custom-select form-control airportpr-select" name="airport_ukraine" id="airport_ukraine2">
													<option value="0">{{ trans('forms.create_order_ph_airportpr') }}</option>
													<option value="Б" class="borispol">Борисполь</option>
													<option value="Ж" class="zhulyany">Жуляны</option>
												</select>
						 
												@if ($errors->has('airport_ukraine'))
													<span class="help-block">
														<strong>{{ $errors->first('airport_ukraine') }}</strong>
													</span>
												@endif
											</div>
										</div>	
									</div>		

									<div class="col-sm-4">
										<div id="terminalpr" class="form-group airportpr-info hidden has-feedback {{ $errors->has('terminal') ? ' has-error ' : '' }}">
											{!! Form::label('terminal', trans('forms.create_order_label_terminal'), array('class' => 'col-md-12 control-label required')); !!}
											<div class="col-md-12">
									
												<select class="custom-select form-control" name="terminal" id="terminal2">
													<option value="0">{{ trans('forms.create_order_ph_terminal') }}</option>
													<option value="D">D</option>
													<option value="F">F</option>
												</select>
						 
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
											{!! Form::label('flight', trans('forms.create_order_label_flight'), array('class' => 'col-md-12 control-label')); !!}
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
									
												<select class="custom-select form-control" name="address" id="address">
													<option value="">{{ trans('forms.create_order_ph_addresspr') }}</option>
													<option value="cherkasy">Черкассы</option>
													<option value="smila">Смела</option>
													<option value="zolotonosha">Золотоноша</option>
												</select>
						 
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
													<option value="group">Групповой</option>
													<option value="individual">Индивидуальный</option>
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

												<select class="custom-select form-control childrenpr-select" name="children" id="children">
													<option value="" class="children_no">нет</option>
													<option value="1" class="children_yes">1</option>
													<option value="2" class="children_yes">2</option>
													<option value="3" class="children_yes">3</option>
													<option value="4" class="children_yes">4</option>
													<option value="5" class="children_yes">5</option>
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
										<div id="childrenpr" class="childrenpr-info hidden form-group has-feedback {{ $errors->has('ticket_child') ? ' has-error ' : '' }}">
											{!! Form::label('ticket_child', trans('forms.create_order_label_ticket_child'), array('class' => 'col-md-12 control-label')); !!}
											<div class="col-md-12">
									
												<select class="custom-select form-control" name="ticket_child" id="ticket_child">
													<option value="">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
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
									<div class="col-md-12">
										<div class="custom-control custom-checkbox" for="option_nameplate_pr">
											<input name="option_nameplate" class="custom-control-input" id="option_nameplate_pr" value="1" type="checkbox"> 
											<label class="custom-control-label" for="option_nameplate_pr">{!! trans('forms.create_order_checkbox_option_nameplate') !!}</label>
										</div>
										<div class="custom-control custom-checkbox" for="option_babyk_pr">
											<input name="option_babyk" class="custom-control-input" id="option_babyk_pr" value="1" type="checkbox"> 
											<label class="custom-control-label" for="option_babyk_pr">{!! trans('forms.create_order_checkbox_option_babyk') !!}</label>
										</div>
										<div class="custom-control custom-checkbox" for="option_babyl_pr">
											<input name="option_babyl" class="custom-control-input" id="option_babyl_pr" value="1" type="checkbox"> 
											<label class="custom-control-label" for="option_babyl_pr">{!! trans('forms.create_order_checkbox_option_babyl') !!}</label>
										</div>
									</div>
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
											<input type="radio" name="status_pay"  class="custom-control-input statusPay_pr" id="status_pay_not_paid_pr" value="not-paid" checked>
											<label class="custom-control-label" for="status_pay_not_paid_pr">{!! trans('forms.create_order_radio_not_paid') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="status_pay_pr">
											<input type="radio" name="status_pay"  class="custom-control-input statusPay_pr" id="status_pay_pr" value="paid">
											<label class="custom-control-label" for="status_pay_pr">{!! trans('forms.create_order_radio_pay') !!}</label>
										</div>
									</div>
								</div>						
									
								<div id="else-statusPay_pr" class="form-group hidden_pr has-feedback {{ $errors->has('ticketfree_reason') ? ' has-error ' : '' }}">
									{!! Form::label('ticketfree_reason', trans('forms.create_order_label_ticketfree_reason'), array('class' => 'col-md-12 control-label')); !!}
									<div class="col-md-12">
										<div class="custom-control custom-radio" for="customerpaid_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="customerpaid_pr" value="customerpaid" checked>
											<label class="custom-control-label" for="customerpaid_pr">{!! trans('forms.create_order_radio_customerpaid') !!}</label>
										</div>							
										<div class="custom-control custom-radio" for="cardpersonal_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardpersonal_pr" value="cardpersonal">
											<label class="custom-control-label" for="cardpersonal_pr">{!! trans('forms.create_order_radio_cardpersonal') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="cardgold_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="cardgold_pr" value="cardgold">
											<label class="custom-control-label" for="cardgold_pr">{!! trans('forms.create_order_radio_cardgold') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="discountfive_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="discountfive_pr" value="discountfive">
											<label class="custom-control-label" for="discountfive_pr">{!! trans('forms.create_order_radio_discountfive') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="discounthalf_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="discounthalf_pr" value="discounthalf">
											<label class="custom-control-label" for="discounthalf_pr">{!! trans('forms.create_order_radio_discounthalf') !!}</label>
										</div>
										<div class="custom-control custom-radio" for="balance_pr">
											<input type="radio" name="ticketfree_reason"  class="custom-control-input" id="balance_pr" value="balance">
											<label class="custom-control-label" for="balance_pr">{!! trans('forms.create_order_radio_balance') !!}</label>
										</div>									
									</div>
								</div>						
									
								{!! Form::button(trans('forms.create_order_button_text'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
								{!! Form::close() !!}
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
			var airportvlSelect = $('.airportvl-select');
			var airportprSelect = $('.airportpr-select');
			var statusPay_vl = $('.statusPay_vl');
			var statusPay_pr = $('.statusPay_pr');
			var childrenvlSelect = $('.childrenvl-select');
			var childrenprSelect = $('.childrenpr-select');

            airportvlSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.airportvl-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('borispol')) {
                    $('#terminalvl').removeClass('hidden');
                } else if (optionSelected.hasClass('zhulyany')) {
                    $('#terminalvl').addClass('hidden');
                }
            });			
			
            airportprSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.airportpr-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('borispol')) {
                    $('#terminalpr').removeClass('hidden');
                } else if (optionSelected.hasClass('zhulyany')) {
                    $('#terminalpr').addClass('hidden');
                }
            });	

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

            childrenvlSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.childrenvl-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('children_yes')) {
                    $('#childrenvl').removeClass('hidden');
                } else if (optionSelected.hasClass('children_no')) {
                    $('#childrenvl').addClass('hidden');
                }
            });	

            childrenprSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.childrenpr-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('children_yes')) {
                    $('#childrenpr').removeClass('hidden');
                } else if (optionSelected.hasClass('children_no')) {
                    $('#childrenpr').addClass('hidden');
                }
            });	

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
		flatpickr("#datetime", {
			//minDate: "today",
			locale: "ru",
			enableTime: true,
			dateFormat: "Y-m-d H:i",
			time_24hr: true,
		});
		flatpickr("#registration", {
			noCalendar: "true",
			enableTime: true,
			dateFormat: "H:i",
			time_24hr: true,
		});


		var terminals = {
			"Б": ["D", "F"]
			//"Ж": ["A", "B", "D"]
		};

		$('#airport_ukraine').change(function(){
			$('#terminal').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

		$('#airport_ukraine2').change(function(){
			$('#terminal2').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal2').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

	</script>
@endsection
