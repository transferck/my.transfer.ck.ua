@extends('layouts.app')

@section('template_title')
    {!!trans('usersmanagement.showing-user-deleted')!!}

@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: .15em;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {!!trans('ordersmanagement.showing-order-deleted')!!}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('orders') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-orders') !!}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(count($orders) === 0)

                            <tr>
                                <p class="text-center margin-half">
                                    {!! trans('usersmanagement.no-records') !!}
                                </p>
                            </tr>

                        @else

                            <div class="table-responsive users-table">
                                <table class="table table-striped table-sm data-table">
                                    <caption id="order_count">
                                        {{ trans_choice('ordersmanagement.orders-table.caption', 1, ['orderscount' => $orders->count()]) }}
                                    </caption>
                                    <thead class="thead">
                                    <tr>
                                        <th>{!! trans('ordersmanagement.orders-table.id') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.fio') !!}</th>
                                        <th class="text-center">{!! trans('ordersmanagement.orders-table.tickets') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.airport') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.datetime-vl') !!}</th>
                                        <th>{!! trans('ordersmanagement.orders-table.registration') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="orders_table">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td><span data-toggle="tooltip" title="{{$order->phone}}"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> {{$order->fio}}</td>
                                            <td class="text-center">{{$order->tickets}}</td>
                                            <td>{{$order->airport_ukraine}}, {{$order->terminal}}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->datetime)->format('d/m')}}, {{ \Carbon\Carbon::parse($order->datetime)->format('H:i')}}</td>
                                            <td>{{$order->registration}}</td>
                                            @if($order->status_order == 'sent')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_sent') !!}</td>
                                            @elseif($order->status_order == 'reservation')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_reservation') !!} </td>
                                            @elseif($order->status_order == 'cencel')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_cencel') !!} </td>
                                            @elseif($order->status_order == 'moved')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_moved') !!}</td>
                                            @elseif($order->status_order == 'update')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_update') !!}</td>
                                            @elseif($order->status_order == 'success')
                                                <td>{!! trans('ordersmanagement.orders-table.status_order_success') !!}</td>
                                            @else($order->status_order == 0)
                                                <td>-</td>
                                            @endif
                                            @if($order->status_pay == 'not-paid')
                                                <td>{!! trans('ordersmanagement.orders-table.status_pay_1') !!}</td>
                                            @elseif($order->status_pay == 'paid')
                                                <td>{!! trans('ordersmanagement.orders-table.status_pay_2') !!}</td>
                                            @else($order->status_order == 0)
                                                <td>-</td>
                                            @endif
                                            <td>
                                                {!! Form::model($order, array('action' => array('OrderDeleteController@update', $order->id), 'method' => 'PUT', 'data-toggle' => 'tooltip')) !!}
                                                {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-block btn-sm', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore Order')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('orders/deleted/' . $order->id) }}" data-toggle="tooltip" title="Show Order">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {!! Form::model($order, array('action' => array('OrderDeleteController@destroy', $order->id), 'method' => 'DELETE', 'class' => 'inline', 'data-toggle' => 'tooltip', 'title' => 'Destroy Order Record')) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::button('<i class="fa fa-user-times" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm inline','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete order', 'data-message' => 'Are you sure you want to delete this order ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tbody id="search_results"></tbody>
                                    @if(config('ordersmanagement.enableSearchOrders'))
                                        <tbody id="search_results"></tbody>
                                    @endif

                                </table>

                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @if (count($orders) > 10)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
