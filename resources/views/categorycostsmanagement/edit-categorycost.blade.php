@extends('layouts.app')

@section('template_title')
    {{ trans('categorycosts.CategoryCostTitle', ['name' => $categorycost->name]) }}
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
                            <strong>{{ trans('categorycosts.editTitle') }}</strong> {{ $categorycost->name }}
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/categorycosts/' . $categorycost->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('categorycosts.backToCategoryCostTt') }}">
                                <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                {!! trans('categorycosts.backToCategoryCostBtn') !!}
                            </a>
                            <a href="{{ url('/categorycosts/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('categorycosts.backToCategoryCostsTt') }}">
                                <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                {!! trans('categorycosts.backToTCategoryCostsBtn') !!}
                            </a>
                        </div>
                    </div>

                    {!! Form::model($categorycost, array('action' => array('CategoryCostsManagementController@update', $categorycost->id), 'method' => 'PUT')) !!}
                        {!! csrf_field() !!}
						<div class="card-body">
							<div class="form-row">
								<div class="col-sm-9">
									<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error ' : '' }}">
										{!! Form::label('name', trans('categorycosts.nameLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">										
												{!! Form::text('name', $categorycost->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('categorycosts.namePlaceholder'))) !!}
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
												{!! Form::number('position', $categorycost->position, array('id' => 'position', 'class' => 'form-control', 'placeholder' => trans('categorycosts.positionPlaceholder'))) !!}
											</div>
											@if ($errors->has('position'))
												<span class="help-block">
													<strong>{{ $errors->first('position') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group has-feedback {{ $errors->has('group') ? ' has-error ' : '' }}">
										{!! Form::label('group', trans('categorycosts.groupLabel'), array('class' => 'col-md-12 control-label required')); !!}
										<div class="col-md-12">
											<div class="input-group">
												{!! Form::select('group', \App\Models\CategoryCost::$GROUPS_LABELS, $categorycost->group, array('id' => 'group', 'class' => 'form-control', 'placeholder' => trans('categorycosts.groupPlaceholder'))) !!}
											</div>
											@if ($errors->has('group'))
												<span class="help-block">
													<strong>{{ $errors->first('group') }}</strong>
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
												{!! Form::text('img', $categorycost->img, array('id' => 'img', 'class' => 'form-control', 'placeholder' => trans('categorycosts.imgPlaceholder'))) !!}
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
                                <div class="col-sm-6">
                                    {!! Form::button('<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('categorycosts.editSave'), array('class' => 'btn btn-success btn-block mb-0 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_categorycost__modal_text_confirm_title'), 'data-message' => trans('modals.edit_categorycost__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.check-changed')
    @include('scripts.toggleStatus')

@endsection
