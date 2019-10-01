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

                {{ trans('categorycosts.costsTitle') }} <strong>{{ count($categorycosts) }}</strong> {{ trans('categorycosts.categorycosts') }}

                <a href="/categorycosts/create" class="btn btn-outline-secondary btn-sm pull-right mb-2">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    {{ trans('categorycosts.btnAddCategoryCost') }}
                </a>

                <div class="table-responsive categorycosts-table">
                    <table class="table table-striped table-sm data-table">
                        <thead class="thead-dark">
                            <tr>
								<th class="ml-2">ID</th>
                                <th>Категория</th>
                                <th>Позиция</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorycosts as $aCategoryCost)
                                <tr>
                                    <td>{{$aCategoryCost->id}}</td>
                                    <td>{{$aCategoryCost->name}}</td>
                                    <td>{{$aCategoryCost->position}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('categorycosts/' . $aCategoryCost->id) }}" data-toggle="tooltip" title="{{ trans('categorycosts.categorycostsBtnShow') }}">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('categorycosts.categorycostsBtnShow') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('categorycosts/' . $aCategoryCost->id . '/edit') }}" data-toggle="tooltip" title="{{ trans('categorycosts.categorycostsBtnEdit') }}">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('categorycosts.categorycostsBtnEdit') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(array('url' => 'categorycosts/' . $aCategoryCost->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete category')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="sr-only">Delete category</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('categorycosts.confirmDeleteHdr'), 'data-message' => trans('categorycosts.confirmDelete'))) !!}
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

    @if (count($categorycosts) > 50)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
