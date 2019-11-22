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
		.side_number {
			position: absolute;
			top: -10px;
			left: -10px;
			font-size: 23px;
		}
		.side_number .badge {
			box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
			padding: 0;
			width: 35px;
			height: 35px;
			text-align: center;
			line-height: 35px;
		}
		.costs-sum {    
			position: absolute;
			bottom: -10px;
			width: 100%;
			text-align: center;
			font-size: 18px;
		}
		.tachometer {
			position: absolute;
			top: 30px;
			right: -12px;
			font-size: 16px;
		}
		.tachometer .badge {
			box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
			padding: .61111em .51111em;
		}
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span>{{ trans('cars.carsTitle') }} <strong>{{ count($cars) }}</strong> {{ trans('cars.cars') }}</span>
                <a href="/cars/create" class="btn btn-outline-secondary pull-right">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    {{ trans('cars.btnAddCar') }}
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="cars-list">
            <div class="row">
                @foreach($cars as $aCar)
                    <div class="col-md-2 mb-4">
                        <div class="card">
                            <div class="side_number">
                                <span class="badge badge-pill badge-warning ">{{$aCar->side_number}}</span>
                            </div>
							<div class="tachometer" data-toggle="tooltip" title="{{ $aCar->getLastDistance() }} км">
                                <span class="badge badge-pill badge-light"> 
									<i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
								</span>
                            </div>
                            <a href="{{ URL::to('cars/' . $aCar->id) }}">
                                <div class="card-body text-center p-0">
                                    <img src="{{ $aCar->getImage()  }}" alt="" class="img-fluid w-75">
                                </div>
                            </a> 
                            <div class="costs-sum" data-toggle="tooltip" title="Расходов на авто">
                                <span class="badge badge-success"><b>{{ $aCar->getAllCostsSum() }} грн.</b></span>
                            </div>
                        </div>
                        <a href="{{ URL::to('cars/' . $aCar->id) }}" class="d-none">
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
