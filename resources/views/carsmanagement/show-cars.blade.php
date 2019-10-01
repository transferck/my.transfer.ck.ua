@extends('layouts.app')

@section('template_title')
    Showing cars
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .cars-table {
            border: 0;
        }
        .cars-table tr td:first-child {
            padding-left: 15px;
        }
        .cars-table tr td:last-child {
            padding-right: 15px;
        }
        .cars-table.table-responsive,
        .cars-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">

                {{ trans('cars.carsTitle') }} <strong>{{ count($cars) }}</strong> {{ trans('cars.cars') }}

                <a href="/cars/create" class="btn btn-outline-secondary btn-sm pull-right mb-2">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    {{ trans('cars.btnAddCar') }}
                </a>

                <div class="table-responsive cars-table">
                    <table class="table table-striped table-sm data-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('cars.side_number') }}</th>	
								<th>{{ trans('cars.registration_number') }}</th>								
                                <th>{{ trans('cars.manufacturer') }}</th>
                                <th>{{ trans('cars.purchase_date') }}</th>
								<th>{{ trans('cars.mileage') }}</th>
                                <th>{{ trans('cars.carsActions') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $aCar)
                                @php
                                    $carStatus = [
                                        'name'  => trans('cars.statusDisabled'),
                                        'class' => 'danger'
                                    ];
                                    if($aCar->status == 1) {
                                        $carStatus = [
                                            'name'  => trans('cars.statusEnabled'),
                                            'class' => 'success'
                                        ];
                                    }

                                    $carCosts = 0;
                                    $carCountClass = 'primary';
                                    foreach($costs as $cost) {
                                        if($cost && $cost->car_id === $aCar->id) {
                                           $carCosts += 1;
                                        }
                                    }
                                    if($carCosts === 1) {
                                        $carCountClass = 'info';
                                    } elseif($carCosts >= 2) {
                                        $carCountClass = 'warning';
                                    } elseif($carCosts === 5) {
                                        $carCountClass = 'success';
                                    } elseif($carCosts === 10) {
                                        $carCountClass = 'danger';
                                    }
                                    if($carCosts === 1) {
                                        $carCountClass = 'info';
                                    } elseif($carCosts >= 2) {
                                        $carCountClass = 'warning';
                                    } elseif($carCosts === 5) {
                                        $carCountClass = 'success';
                                    } elseif($carCosts === 10) {
                                        $carCountClass = 'danger';
                                    }									
                                @endphp
                                <tr>
                                    <td>{{$aCar->id}}</td>
									<td>{{$aCar->side_number}}</td>
									<td>{{$aCar->registration_number}}</td>
									@if($aCar->manufacturer == 'renault') 
                                        <td>Renault</td>
                                    @elseif($aCar->manufacturer == 'opel') 
                                        <td>Opel</td>
									@endif									
									<td>{{$aCar->purchase_date}}</td>
									<td>{{$aCar->mileage}}</td>									
                                    <td class="d-none">
                                        <span class="label label-{{ $carStatus['class'] }}">
                                            {{ $carStatus['name'] }}
                                        </span>
                                    </td>
                                    <td class="d-none">
                                        <span class="label label-{{ $carCountClass }}" style="margin-left: 6px">
                                            {{ $carCosts }}
                                        </span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('cars/' . $aCar->id) }}" data-toggle="tooltip" title="{{ trans('cars.carsBtnShow') }}">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('cars.carsBtnShow') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('cars/' . $aCar->id . '/edit') }}" data-toggle="tooltip" title="{{ trans('cars.carsBtnEdit') }}">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('cars.carsBtnEdit') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(array('url' => 'cars/' . $aCar->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete car')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="sr-only">Delete car</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('cars.confirmDeleteHdr'), 'data-message' => trans('cars.confirmDelete'))) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @if (count($cars) > 50)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
