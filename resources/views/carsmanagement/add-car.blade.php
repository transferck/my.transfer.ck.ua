@extends('layouts.app')

@section('template_title')
  {{ trans('titles.carAdd') }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-10 offset-xl-1">
                <div class="card">

                    <div class="card-header">
                        <div class="float-left">
                            {{ trans('cars.AddCar') }}
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/cars/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('themes.backToThemesTt') }}">
                                <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                {!! trans('themes.backToThemesBtn') !!}
                            </a>
                        </div>
                    </div>


                    {!! Form::open([
                    	'action' => 'CarsManagementController@store', 'method' => 'POST',
                    	'role' => 'form',
                    	'enctype' => 'multipart/form-data'
					]) !!}

                        {!! csrf_field() !!}

                        <div class="card-body">

							<div class="form-row">	
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('manufacturer') ? ' has-error ' : '' }}">
										{!! Form::label('manufacturer', trans('cars.manufacturerLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											{!! Form::select('manufacturer',  array('renault' => 'Renault', 'opel' => 'Opel'), 'null', ['placeholder' => trans('cars.manufacturerPlaceholder'), 'id' => 'manufacturer', 'class' => 'custom-select form-control manufacturer-select']) !!}	
											@if ($errors->has('manufacturer'))
												<span class="help-block">
													<strong>{{ $errors->first('manufacturer') }}</strong>
												</span>
											@endif
										</div>
									</div>	
								</div>								
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('registration_number') ? ' has-error ' : '' }}">
										{!! Form::label('registration_number', trans('cars.registration_numberLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="registration_number">
														<i class="fa fa-fw {{ trans('cars.modelIcon') }}" aria-hidden="true"></i>
													</label>
												</div>
												{!! Form::text('registration_number', NULL, array('id' => 'registration_number', 'class' => 'form-control', 'placeholder' => trans('cars.registration_numberPlaceholder'))) !!}
											</div>
											@if ($errors->has('registration_number'))
												<span class="help-block">
													<strong>{{ $errors->first('registration_number') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>											

								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('side_number') ? ' has-error ' : '' }}">
										{!! Form::label('side_number', trans('cars.side_numberLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											{!! Form::select('side_number',  array('11' => '11', '24' => '24', '26' => '26', '42' => '42', '46' => '46', '64' => '64', '73' => '73', '74' => '74', '78' => '78', '80' => '80', '84' => '84', '93' => '93', '70' => '70', '33' => '33'), 'null', ['placeholder' => trans('cars.side_numberPlaceholder'), 'id' => 'side_number', 'class' => 'custom-select form-control']) !!}
											@if ($errors->has('side_number'))
												<span class="help-block">
													<strong>{{ $errors->first('side_number') }}</strong>
												</span>
											@endif
										</div>
									</div>									
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('color') ? ' has-error ' : '' }}">
										{!! Form::label('color', trans('cars.colorLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											{!! Form::select('color',  array('white' => 'Белый', 'black' => 'Черный', 'silver' => 'Cеребристый', 'green' => 'Зеленый', 'red' => 'Красный'), 'null', ['placeholder' => trans('cars.colorPlaceholder'), 'id' => 'color', 'class' => 'custom-select form-control color-select']) !!}	
											@if ($errors->has('color'))
												<span class="help-block">
													<strong>{{ $errors->first('color') }}</strong>
												</span>
											@endif
										</div>
									</div>	
								</div>									
							</div>

							<div class="form-row">							
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('purchase_date') ? ' has-error ' : '' }}">
										{!! Form::label('purchase_date', trans('cars.purchase_dateLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="purchase_date">
														<i class="fa fa-fw {{ trans('cars.purchase_dateIcon') }}" aria-hidden="true"></i>
													</label>
												</div>												
												{!! Form::text('purchase_date', NULL, array('id' => 'purchase_date', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('cars.purchase_datePlaceholder'))) !!}
											</div>
											@if ($errors->has('purchase_date'))
												<span class="help-block">
													<strong>{{ $errors->first('purchase_date') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('release_date') ? ' has-error ' : '' }}">
										{!! Form::label('release_date', trans('cars.release_dateLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="release_date">
														<i class="fa fa-fw {{ trans('cars.purchase_dateIcon') }}" aria-hidden="true"></i>
													</label>
												</div>												
												{!! Form::text('release_date', NULL, array('id' => 'release_date', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('cars.release_datePlaceholder'))) !!}
											</div>
											@if ($errors->has('release_date'))
												<span class="help-block">
													<strong>{{ $errors->first('release_date') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>	
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('condition') ? ' has-error ' : '' }}">
										{!! Form::label('condition', trans('cars.conditionLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											{!! Form::select('condition',  array('new' => 'Новый', 'mileage' => 'С пробегом'), 'null', ['placeholder' => trans('cars.conditionPlaceholder'), 'id' => 'manufacturer', 'class' => 'custom-select form-control manufacturer-select']) !!}	
											@if ($errors->has('condition'))
												<span class="help-block">
													<strong>{{ $errors->first('condition') }}</strong>
												</span>
											@endif
										</div>
									</div>	
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('mileage') ? ' has-error ' : '' }}">
										{!! Form::label('mileage', trans('cars.mileageLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="mileage">
														<i class="fa fa-fw {{ trans('cars.purchase_dateIcon') }}" aria-hidden="true"></i>
													</label>
												</div>												
												{!! Form::text('mileage', NULL, array('id' => 'mileage', 'class' => 'form-control flatpickr-input', 'placeholder' => trans('cars.mileagePlaceholder'))) !!}
											</div>
											@if ($errors->has('mileage'))
												<span class="help-block">
													<strong>{{ $errors->first('mileage') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>									
							</div>
						
							<div class="form-row">	
								<div class="col-sm-12">
									<div class="form-group has-feedback {{ $errors->has('status') ? ' has-error ' : '' }}">
										{!! Form::label('status', trans('cars.statusLabel') , array('class' => 'col-md-3 control-label')); !!}
										<div class="col-md-9">
											<label class="switch checked" for="status">
												<span class="active"><i class="fa fa-toggle-on fa-2x"></i> {{ trans('cars.statusEnabled') }}</span>
												<span class="inactive"><i class="fa fa-toggle-on fa-2x fa-rotate-180"></i> {{ trans('cars.statusDisabled') }}</span>
												<input type="radio" name="status" value="1" checked>
												<input type="radio" name="status" value="0">
											</label>

											@if ($errors->has('status'))
												<span class="help-block">
													<strong>{{ $errors->first('status') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="row form-group has-feedback {{ $errors->has('image') ? ' has-error ' : '' }}">
										<div class="col-md-6">
											<input id="image" type="file" class="form-control" name="image">
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group has-feedback {{ $errors->has('notes') ? ' has-error ' : '' }}">
										{!! Form::label('notes', trans('cars.notesLabel') , array('class' => 'col-md-3 control-label')); !!}
										<div class="col-md-9">
											<div class="input-group">
												{!! Form::textarea('notes', old('notes'), array('id' => 'notes', 'class' => 'form-control', 'placeholder' => trans('cars.notesPlaceholder'))) !!}
												<div class="input-group-append">
													<label for="notes" class="input-group-text">
														<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
													</label>
												</div>
											</div>
											@if ($errors->has('notes'))
												<span class="help-block">
													<strong>{{ $errors->first('notes') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
							</div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-6 offset-sm-6">
                                    {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;' . trans('cars.btnAddCar'), array('class' => 'btn btn-success btn-block mb-0','type' => 'submit', )) !!}
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')

  @include('scripts.toggleStatus')

@endsection
