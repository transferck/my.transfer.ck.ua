@extends('layouts.app')

@section('template_title')
    {{ trans('categorycosts.showHeadTitle') . ' ' . $categorycost->name }}
@endsection

@section('template_fastload_css')

    .list-group-responsive span:not(.badge) {
        display: block;
        overflow-y: auto;
    }
    .list-group-responsive span.badge {
        margin-left: 7.25em;
    }

    .categorycost-details-list strong {
        width: 5.5em;
        display: inline-block;
        position: absolute;
    }

    .categorycost-details-list span {
        margin-left: 5.5em;
    }

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    {{ trans('categorycosts.showTitle') }}
                    <a href="/categorycosts/" class="btn btn-primary btn-sm pull-right">
                      <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                      {{ trans('categorycosts.showBackBtn') }}
                    </a>
                </div>
                <div class="card-body">

                    <h1 class="text-center">
                        {{ $categorycost->name }}
                    </h1>

                    <h4 class="text-center margin-bottom-2">
                        <span class="badge">{{ count($categorycostCosts) }}</span> {{ trans('categorycosts.showCosts') }}
                    </h4>

                    <ul class="list-group list-group-responsive categorycost-details-list margin-bottom-3">
                        <li class="list-group-item"><strong>Id</strong> <span>{{ $categorycost->id }}</span></li>
						<li class="list-group-item"><strong>Position</strong> <span>{{ $categorycost->position }}</span></li>
                    </ul>

                    @if(count($categorycostCosts) > 0)
                        <h4 class="text-center margin-bottom-2">
                            <i class="fa fa-users fa-fw" aria-hidden="true"></i> categorycost Costs
                        </h4>

                        <ul class="list-group">
                            @foreach ($categorycostCosts as $categorycostCost)
                                <li class="list-group-item"><i class="fa fa-user fa-fw margin-right-1" aria-hidden="true"></i> {{ $categorycostCost->categorycost_id }}</li>
                            @endforeach
                        </ul>
                    @endif

                </div>
                <div class="card-footer">
                    <div class="row pt-2">
                        <div class="col-sm-6 mb-2">
                            <a href="/categorycosts/{{$categorycost->id}}/edit" class="btn btn-small btn-info btn-block">
                                <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit<span class="hidden-sm"> this</span><span class="hidden-sm"> categorycost</span>
                            </a>
                        </div>
                        {!! Form::open(array('url' => 'categorycosts/' . $categorycost->id, 'class' => 'col-sm-6 mb-2')) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete<span class="hidden-sm"> this</span><span class="hidden-sm"> categorycost</span>', array('class' => 'btn btn-danger btn-block btn-flat','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('categorycosts.confirmDeleteHdr'), 'data-message' => trans('categorycosts.confirmDelete'))) !!}
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
