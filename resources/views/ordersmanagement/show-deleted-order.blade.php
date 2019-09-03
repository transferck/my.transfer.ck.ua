@extends('layouts.app')

@section('template_title')
    {!! trans('ordersmanagement.showing-order', ['fio' => $order->fio]) !!}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="card">



                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
    @if(config('ordersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
@endsection
