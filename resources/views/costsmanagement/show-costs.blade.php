@extends('layouts.app')

@section('template_title')
    Showing costs
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .costs-table {
            border: 0;
        }
        .costs-table tr td:first-child {
            padding-left: 15px;
        }
        .costs-table tr td:last-child {
            padding-right: 15px;
        }
        .costs-table.table-responsive,
        .costs-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">

                {{ trans('costs.costsTitle') }} <strong>{{ count($costs) }}</strong> {{ trans('costs.costs') }}

                <a href="/costs/create" class="btn btn-outline-secondary btn-sm pull-right mb-2">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    {{ trans('costs.btnAddCost') }}
                </a>

                <div class="table-responsive costs-table">
                    <table class="table table-striped table-sm data-table">
                        <thead class="thead-dark">
                            <tr>
								<th class="ml-2">ID</th>
                                <th>Бортовой номер</th>
                                <th>Категория</th>
                                <th>Цена</th>
								<th>Шт.</th>
                                <th>Работа</th>
								<th>Примечание</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costs as $aCost)
                                <tr>
                                    <td>{{ $aCost->id }}</td>
                                    <td>{{ $aCost->car->side_number }}</td>
                                    <td>{{ $aCost->category->name }}</td>
									<td>{{ $aCost->purchase_cost }}</td>
									<td>{{ $aCost->count }}</td>
									<td>{{ $aCost->work_price }}</td>
                                    <td>{{ $aCost->notes }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('costs/' . $aCost->id) }}" data-toggle="tooltip" title="{{ trans('costs.costsBtnShow') }}">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('costs.costsBtnShow') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('costs/' . $aCost->id . '/edit') }}" data-toggle="tooltip" title="{{ trans('costs.costsBtnEdit') }}">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('costs.costsBtnEdit') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(array('url' => 'costs/' . $aCost->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete cost')) !!}
                                            @method('DELETE')
                                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="sr-only">Delete cost</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('costs.confirmDeleteHdr'), 'data-message' => trans('costs.confirmDelete'))) !!}
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

    @if (count($costs) > 5)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
