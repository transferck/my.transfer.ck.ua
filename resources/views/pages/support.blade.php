@extends('layouts.app')

@section('template_title')
	Техподдержка
@endsection

@section('head')
@endsection

@section('content')

<div class="container">
	<div class="row">
	    <div class="col-lg-10 offset-lg-1">
			<div class="card">
				<div class="card-header"><h5 class="mb-0"> Техподдержка</h5></div> 
				<div class="card-body">
					<div class="row"><div class="col-lg col-xxl-5"><h6 class="font-weight-semi-bold ls mb-3 text-uppercase">Связаться с нами</h6> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1">Техподдержка:</p></div> <div class="col">+38 (097) 664-7286 (Владимир)</div></div> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1">Менеджер по работе с турагентствами:</p></div> <div class="col">+38 (063) 961-5933 (Инна)</div></div>
					<div class="row mt-3"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1">Оператор программы:</p></div><div class="col">Рабочаем с 09.00 до 20:00</div> </div> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1">Операторы:</p></div> <div class="col">Круглосуточно</div></div> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1"></p></div> <div class="col">+38 (093) 755-5606 (Viber\Whatsapp)</div></div>
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1"></p></div> <div class="col">+38 (096) 050-6160</div></div> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1"></p></div> <div class="col">+38 (066) 755-5660</div></div> 
					<div class="row"><div class="col-5 col-sm-5"><p class="font-weight-semi-bold mb-1">E-mail:</p></div> <div class="col"><a href="mailto:transfer.cherkassy@gmail.com">transfer.cherkassy@gmail.com</a></div></div></div></div>
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