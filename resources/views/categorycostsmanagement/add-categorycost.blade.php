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
                            {{ trans('categorycosts.AddCategoryCost') }}
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/categorycosts/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('categorycosts.backToThemesTt') }}">
                                <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                {!! trans('categorycosts.backToCategoryCostsBtn') !!}
                            </a>
                        </div>
                    </div>
                    {!! Form::open(array('action' => 'CategoryCostsManagementController@store', 'method' => 'POST', 'role' => 'form')) !!}
                        {!! csrf_field() !!}
                        <div class="card-body">
							<div class="form-row">
								<div class="col-sm-9">
									<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error ' : '' }}">
										{!! Form::label('name', trans('categorycosts.nameLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">										
												{!! Form::text('name', NULL, array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('categorycosts.namePlaceholder'))) !!}
											</div>
											@if ($errors->has('name'))
												<span class="help-block">
													<strong>{{ $errors->first('name') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('position') ? ' has-error ' : '' }}">
										{!! Form::label('position', trans('categorycosts.positionLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">										
												{!! Form::number('position', NULL, array('id' => 'position', 'class' => 'form-control', 'placeholder' => trans('categorycosts.positionPlaceholder'))) !!}
											</div>
											@if ($errors->has('position'))
												<span class="help-block">
													<strong>{{ $errors->first('position') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>								
							</div>
							<div class="form-row">
								<div class="col-sm-12">
									<div class="form-group has-feedback {{ $errors->has('img') ? ' has-error ' : '' }}">
										{!! Form::label('img', trans('categorycosts.imgLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">										
												{!! Form::text('img', NULL, array('id' => 'img', 'class' => 'form-control', 'placeholder' => trans('categorycosts.imgPlaceholder'))) !!}
											</div>
											@if ($errors->has('img'))
												<span class="help-block">
													<strong>{{ $errors->first('img') }}</strong>
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
                                    {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;' . trans('categorycosts.btnAddCategoryCost'), array('class' => 'btn btn-success btn-block mb-0','type' => 'submit', )) !!}
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