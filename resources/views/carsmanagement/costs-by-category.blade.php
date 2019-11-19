@extends('layouts.app')

@section('template_title')
    {{ trans('cars.showHeadTitle') . ' ' . $car->side_number }} - Расходы
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<span>Показано все <strong>{{ $car->side_number }}</strong> авто</span>
				<a href="/cars/{{ $car->id }}" class="btn btn-outline-secondary pull-right">Назад до авто</a>
			</div>
		</div>
	</div>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                @if(count($costs))
                    <div class="table-responsive costs-table">
                        <table class="table table-striped table-sm data-table">
                            <thead class="thead-dark">
                            <tr>
                                <th class="ml-2">ID</th>
                                {{-- <th>Бортовой номер</th> --}}
								<th>Дата</th>
								<th>Наименование</th>
                                <th>Категория рассходов</th>
								<th>Шт.</th>
                                <th>Цена, грн.</th>
                                <th>Работа, грн.</th>
								<th>Общая сумма</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($costs as $cost)
                                <tr>
                                    <td>{{ $cost->id }}</td>
                                    {{-- <td>{{ $cost->car->side_number }}</td> --}}
									<td>{{ $cost->updated_at }}</td>
									<td>{{ $cost->notes }}</td>
                                    <td>{{ $cost->category->name }}</td>
                                    <td>{{ $cost->count }}</td>									
                                    <td>{{ $cost->purchase_cost }}</td>
                                    <td>{{ $cost->work_price }}</td>
									<td>{{ $cost->purchase_cost +  $cost->work_price}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('costs/' . $cost->id) }}" data-toggle="tooltip" title="{{ trans('costs.costsBtnShow') }}">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('costs.costsBtnShow') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('costs/' . $cost->id . '/edit') }}" data-toggle="tooltip" title="{{ trans('costs.costsBtnEdit') }}">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">{{ trans('costs.costsBtnEdit') }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        {!! Form::open(array('url' => 'costs/' . $cost->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete cost')) !!}
                                        @method('DELETE')
                                        {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="sr-only">Delete cost</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('costs.confirmDeleteHdr'), 'data-message' => trans('costs.confirmDelete'))) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h2>Расходов не найдено</h2>
                @endif
            </div>
        </div>
    </div>
@endsection