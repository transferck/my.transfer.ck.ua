@extends('layouts.app')

@section('template_title')
    {{ trans('costs.showHeadTitle') . ' ' . $cost->name }}
@endsection

@section('template_fastload_css')

    .list-group-responsive span:not(.badge) {
        display: block;
        overflow-y: auto;
    }
    .list-group-responsive span.badge {
        margin-left: 7.25em;
    }

    .cost-details-list strong {
        width: 5.5em;
        display: inline-block;
        position: absolute;
    }

    .cost-details-list span {
        margin-left: 5.5em;
    }

@endsection

@php
    $costStatus = [
        'name'  => trans('costs.statusDisabled'),
        'class' => 'danger'
    ];
    if($cost->status == 1) {
        $costStatus = [
            'name'  => trans('costs.statusEnabled'),
            'class' => 'success'
        ];
    }
@endphp

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    {{ trans('costs.showTitle') }}
                    <a href="/costs/" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                      {{ trans('costs.showBackBtn') }}
                    </a>
                </div>
                <div class="card-body">

                    <h1 class="text-center">
                        {{ $cost->name }}
                    </h1>

                    <h4 class="text-center margin-bottom-2">
                        <span class="badge">{{ count($costUsers) }}</span> {{ trans('costs.showUsers') }}
                    </h4>

                    <ul class="list-group list-group-responsive cost-details-list margin-bottom-3">

                        <li class="list-group-item">
                            <strong>{{ trans('costs.showStatus') }}</strong>
                            <span class="badge badge-{{ $costStatus['class'] }}">
                                {{ $costStatus['name'] }}
                            </span>
                        </li>

                        <li class="list-group-item"><strong>Id</strong> <span>{{ $cost->id }}</span></li>

                        @if($cost->link != null)
                            <li class="list-group-item"><strong>{{ trans('costs.showLink') }}</strong> <span> <a href="{{$cost->link}}" target="_blank" data-toggle="tooltip" title="Go to Link">{{$cost->link}}</a></span></li>
                        @endif

                        @if($cost->notes != null)
                            <li class="list-group-item"><strong>{{ trans('costs.showNotes') }}</strong> <span>{{ $cost->notes }}</span></li>
                        @endif

                        <li class="list-group-item"><strong>{{ trans('costs.showAdded') }}</strong> <span>{{ $cost->created_at }}</span></li>
                        <li class="list-group-item"><strong>{{ trans('costs.showUpdated') }}</strong> <span>{{ $cost->updated_at }}</span></li>
                    </ul>

                    @if(count($costUsers) > 0)
                        <h4 class="text-center margin-bottom-2">
                            <i class="fa fa-users fa-fw" aria-hidden="true"></i> cost Users
                        </h4>

                        <ul class="list-group">
                            @foreach ($costUsers as $costUser)
                                <li class="list-group-item"><i class="fa fa-user fa-fw margin-right-1" aria-hidden="true"></i> {{ $costUser->name }}</li>
                            @endforeach
                        </ul>
                    @endif

                </div>
                <div class="card-footer">
                    <div class="row pt-2">
                        <div class="col-sm-6 mb-2">
                            <a href="/costs/{{$cost->id}}/edit" class="btn btn-small btn-info btn-block">
                                <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit<span class="hidden-sm"> this</span><span class="hidden-sm"> cost</span>
                            </a>
                        </div>
                        {!! Form::open(array('url' => 'costs/' . $cost->id, 'class' => 'col-sm-6 mb-2')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete<span class="hidden-sm"> this</span><span class="hidden-sm"> cost</span>', array('class' => 'btn btn-danger btn-block btn-flat','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('costs.confirmDeleteHdr'), 'data-message' => trans('costs.confirmDelete'))) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.tooltips')

@endsection
