@extends('layouts.app')

@section('template_title')
    {{ trans('titles.orders-statsNav') }}
@endsection

@section('template_linked_css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css">
@endsection

@section('content')

<div class="container"> 
	<div class="row d-none">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header"><h5 class="mb-0"> Общая статистика</h5></div> 
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<canvas id="chart2" width="1400" height="400"></canvas>
						</div>
						<div class="col-md-12">
							<canvas id="chart1" width="1400" height="400"></canvas>
						</div>
						<div class="col-md-12">
							<canvas id="chart3" width="1400" height="400"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header"><h5 class="mb-0"> Статистика за месяц</h5></div> 
				<div class="card-body">
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней создано:</b></p><span><b>{{$orders_month->count()}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней выполнено:</b></p><span><b>{{$success_month}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Пассажиров доставлено:</b></p><span><b>{{$passangers_month}}</b> чел.</span>
					</div>					
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Вознаграждение:</b></p><span><b>{{$totalSumaMonth}}</b> грн.</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header"><h5 class="mb-0">Прошлый месяц</h5></div>
				<div class="card-body">
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней создано:</b></p><span><b>{{$orders_last_month->count()}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней выполнено:</b></p><span><b>{{$success_last_month}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Пассажиров доставлено:</b></p><span><b>{{$passangers_last_month}}</b> чел.</span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Вознаграждение:</b></p><span><b>{{$totalSumaLastMonth}}</b> грн.</span>
					</div>
				</div>
			</div>
		</div>		
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header"><h5 class="mb-0"> Все время</h5></div> 
				<div class="card-body"> 
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней создано:</b></p><span><b>{{$orders->count()}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Броней выполнено:</b></p><span><b>{{$success_order}}</b></span>
					</div>
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Пассажиров доставлено:</b></p><span><b>{{$passangers_orders}}</b> чел.</span>
					</div>					
					<div class="d-flex justify-content-between fs--1 mb-1">
						<p class="mb-0"><b>Вознаграждение:</b></p><span><b>{{$totalSuma}}</b> грн.</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p class="text-center mt-2"><small>*Вознаграждение рассчитывается автоматически с учетом платы за 1 пассажира: <b>50</b> грн. (<a href="/partners">Уровень
				@if($passangers_orders == 0) 0 @endif
				@if($passangers_orders > 0 && $passangers_orders <= 7) 3 @endif
				@if($passangers_orders >= 8 && $passangers_orders < 19) 2 @endif
				@if($passangers_orders >= 20 ) 1 @endif
			</a>)</small></p>
</div>

@endsection

@section('footer_scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>
	@include('scripts.charts')
@endsection