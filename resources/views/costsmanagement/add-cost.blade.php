@extends('layouts.app')

@section('template_title')
  {{ trans('titles.adminThemesAdd') }}
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
                            {{ trans('costs.AddCost') }}
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/costs/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('themes.backToThemesTt') }}">
                                <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                {!! trans('themes.backToThemesBtn') !!}
                            </a>
                        </div>
                    </div>


                    {!! Form::open(array('action' => 'CostsManagementController@store', 'method' => 'POST', 'role' => 'form')) !!}

                        {!! csrf_field() !!}

                        <div class="card-body">

							<div class="form-row">	
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('car') ? ' has-error ' : '' }}">
										{!! Form::label('car', trans('costs.carLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">	
											<select class="form-control" name="car_id" id="car">
												@if (isset($cost->id))
													<option disabled selected>Не выбран</option>
													@foreach($cars as $aCars)
														<option value="{{ $aCars->id }}" @if($cost && $cost->car_id == $aCars->id) selected="" @endif>{{ $aCars->side_number }}</option>
													@endforeach;
												@else
													<option disabled selected>Не выбран</option>
													@foreach($cars as $aCars)
														<option value="{{ $aCars->id }}" @if($cost && $cost->car_id == $aCars->id) selected="" @endif>{{ $aCars->side_number }}</option>
													@endforeach;
												@endif
											</select>

											@if ($errors->has('car_id'))
												<span class="help-block">
													<strong>{{ $errors->first('car_id') }}</strong>
												</span>
											@endif
										</div>	
									</div>	
								</div>								
								<div class="col-sm-6">
									<div class="form-group has-feedback {{ $errors->has('category_consumption') ? ' has-error ' : '' }}">
										{!! Form::label('category_consumption', trans('costs.category_consumptionLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<select class="custom-select form-control category_consumption-select" name="category_consumption" id="category_consumption">
												@if (isset($cost->id))
													<option disabled selected>Не выбрана</option>
													@foreach($categorycosts as $aCategoryCost)
														<option value="{{ $aCategoryCost->id }}" @if($cost && $cost->categorycost_id == $aCategoryCost->id) selected="" @endif>{{ $aCategoryCost->name }}</option>
													@endforeach;
												@else
													<option disabled selected>Не выбрана</option>
													@foreach($categorycosts as $aCategoryCost)
														<option value="{{ $aCategoryCost->id }}" @if($cost && $cost->categorycost_id == $aCategoryCost->id) selected="" @endif>{{ $aCategoryCost->name }}</option>
													@endforeach;
												@endif
											</select>
											@if ($errors->has('category_consumption'))
												<span class="help-block">
													<strong>{{ $errors->first('category_consumption') }}</strong>
												</span>
											@endif
										</div>
									</div>	
								</div>																									
							</div>

							<div class="form-row">	
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('count') ? ' has-error ' : '' }}">
										{!! Form::label('count', trans('costs.countLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												{!! Form::number('count', 1, array('id' => 'count', 'class' => 'form-control', 'placeholder' => trans('costs.countPlaceholder'))) !!}
											</div>
											@if ($errors->has('count'))
												<span class="help-block">
													<strong>{{ $errors->first('count') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>							
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('purchase_cost') ? ' has-error ' : '' }}">
										{!! Form::label('purchase_cost', trans('costs.purchase_costLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">											
												{!! Form::number('purchase_cost', NULL, array('id' => 'purchase_cost', 'class' => 'form-control', 'placeholder' => trans('costs.purchase_costPlaceholder'))) !!}
											</div>
											@if ($errors->has('purchase_cost'))
												<span class="help-block">
													<strong>{{ $errors->first('purchase_cost') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('work_price') ? ' has-error ' : '' }}">
										{!! Form::label('work_price', trans('costs.work_priceLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">												
												{!! Form::number('work_price', NULL, array('id' => 'work_price', 'class' => 'form-control', 'placeholder' => trans('costs.work_pricePlaceholder'))) !!}
											</div>
											@if ($errors->has('work_price'))
												<span class="help-block">
													<strong>{{ $errors->first('work_price') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>									
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('mileage') ? ' has-error ' : '' }}">
										{!! Form::label('mileage', trans('costs.mileageLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												{!! Form::number('mileage', NULL, array('id' => 'mileage', 'class' => 'form-control', 'placeholder' => trans('costs.mileagePlaceholder'))) !!}
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
									<div class="form-group has-feedback {{ $errors->has('notes') ? ' has-error ' : '' }}">
										{!! Form::label('notes', trans('costs.notesLabel') , array('class' => 'col-md-3 control-label')); !!}
										<div class="col-md-12">
											<div class="input-group">
												{!! Form::textarea('notes', old('notes'), array('id' => 'notes', 'class' => 'form-control', 'rows' => '5', 'placeholder' => trans('costs.notesPlaceholder'))) !!}
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
                                    {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;' . trans('costs.btnAddCost'), array('class' => 'btn btn-success btn-block mb-0','type' => 'submit', )) !!}
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
