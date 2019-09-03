@extends('layouts.app')

@section('template_title')
	Партнерская программа
@endsection

@section('head')
@endsection

@section('content')

 <div class="container">
	<div class="row">
	    <div class="col-lg-10 offset-lg-1">
			<div class="card">
				<div class="card-header"><h5 class="mb-0"> Партнерская программа</h5></div> 
				<div class="card-body"> 
					<p>Компания «Трансфер Черкассы» предлагает новую систему вознаграждения для своих партнеров. Увеличивайте свое ежемесячное вознаграждение бронируя пассажиров через электронный кабинет агента: https://phpstack-244841-977006.cloudwaysapps.com/:</p>
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">Уровень</th>
								<th scope="col">Кол. пассажиров</th>
								<th scope="col">Плата за 1 чел., грн.</th>
								<th class="white-space-nowrap" scope="col">Дополнительные бонусы</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>21 и более</td>
								<td>50</td>
								<td class="white-space-nowrap">
									<img width="20" src="/images/icons/cardpersonal.png" data-toggle="tooltip" title="Именная карта на бесплатный проезд для менеджеров (на 1 год)">
									<span class="badge badge-pill badge-soft-dark ml-2">2</span>
									<img class="ml-2" width="20" src="/images/icons/cardgold.png" data-toggle="tooltip" title="Золотая карта на разовый проезд для пассажиров (ежемесячно)">
									<span class="badge badge-pill badge-soft-dark ml-2">1</span>
									<img class="ml-2" width="20" src="/images/icons/brandmail.png" data-toggle="tooltip" title="Снижена стоимость бренд. конверты">
								</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>9-20</td>
								<td>50</td>
								<td class="white-space-nowrap">
									<img width="20" src="/images/icons/cardpersonal.png" data-toggle="tooltip" title="Именная карта на бесплатный проезд для менеджеров (на 1 год)">
									<span class="badge badge-pill badge-soft-dark ml-2">1</span>
									<img class="ml-2" width="20" src="/images/icons/brandmail.png" data-toggle="tooltip" title="Снижена стоимость бренд. конверты">
								</td>
							</tr>							
							<tr>
								<th scope="row">3</th>
								<td>1-8</td>
								<td>50</td>
								<td class="white-space-nowrap">
									<img width="20" src="/images/icons/discounthalf.png" data-toggle="tooltip" title="Дисконт -50% на один проезд для менеджеров (ежемесячно)">
									<span class="badge badge-pill badge-soft-dark ml-2">1</span>
									<span class="badge badge-pill badge-soft-dark ml-2">-50%</span>
								</td>
							</tr>						
						</tbody>
					</table>
					<p>
					* Расчет вознаграждения автоматически в конце каждого месяца<br>
					** Учитываются брони со статусом «Выполнено»<br>
					*** Выплата вознаграждений с 12 по 18 следующего месяца<br>
					**** Ежемесячный бонус - возможность создать одно бронирование с одним пассажиром (бонусы не накапливаются)</p>
				</div>
			</div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
	@if(config('ordersmanagement.tooltipsEnabled'))
		@include('scripts.tooltips')
	@endif
@endsection