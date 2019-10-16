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
                <span>{{ trans('cars.carsTitle') }} <strong>{{ count($cars) }}</strong> {{ trans('cars.cars') }}</span>
                <a href="/cars/create" class="btn btn-outline-secondary pull-right mb-2">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    {{ trans('cars.btnAddCar') }}
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="cars-list">
            <div class="row">
                @foreach($cars as $aCar)
                    <div class="col-md-2 mb-3">
                        <div class="card">
                            <div class="sost-summ"
                                 style="position: absolute;top: -10px;left: -10px;width: 100%;text-align: left;">
                                <span class="badge badge-success ">{{$aCar->side_number}}</b></span>
                            </div>
                            <a href="{{ URL::to('cars/' . $aCar->id) }}">
                                <div class="card-body text-center p-0">
                                    <img src="/images/icons/cars/1.jpg" alt="" class="img-fluid w-75">
                                </div>
                            </a>
                            <div class="price-summ d-none"
                                 style="position: absolute;bottom: -10px;width: 100%;text-align: center;">
                                <span class="badge badge-success">Cумма: <b>{{$aCar->side_number}}</b></span>
                            </div>
                        </div>
                        <a href="{{ URL::to('cars/' . $aCar->id) }}">
                            <h6 class="text-center mt-3"><b>{{$aCar->registration_number}}</b></h6>
                        </a>

                    </div>
                @endforeach
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
