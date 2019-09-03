@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<div class="card">
    <div class="card-body">
		<p class="my-5 text-center"><img width="500" src="/images/transfer-logo.png" alt=""></p>
        <h2 class="text-center">
            Добро пожаловать!
        </h2>
        <p class="text-center">
            Вы вошли в личный кабинет! У вас есть доступ
			<strong>
				@role('admin')
				   администратора
				@endrole
				@role('operator')
				   оператора
				@endrole
				@role('agent')
				   агента
				@endrole					
				@role('user')
				   пользователя
				@endrole
			</strong>
        </p>
		<div class="d-block mb-3 text-center">
			@role('admin')
				<a class="btn btn-danger {{ Request::is('/orders/deleted') ? 'active' : null }}" href="{{ url('/orders/deleted') }}">{!! trans('titles.agentDeleteOrder') !!}</a>
			@endrole
			@role('operator')
				<a class="btn btn-success {{ Request::is('/orders-all') ? 'active' : null }}" href="{{ url('/orders-all') }}">{!! trans('titles.orders-allNav') !!}</a>
				<a class="btn btn-success {{ Request::is('/agents-all') ? 'active' : null }}" href="{{ url('/agents-all') }}">{!! trans('titles.agents-allNav') !!}</a>				
			@endrole
			@role('agent')
				<a class="btn btn-success {{ Request::is('/orders/create') ? 'active' : null }}" href="{{ url('/orders/create') }}">{!! trans('titles.agentNewOrder') !!}</a>
				<a class="btn btn-success {{ Request::is('/orders') ? 'active' : null }}" href="{{ url('/orders') }}">{!! trans('titles.orderDropdownNav') !!}</a>
				<a class="btn btn-success {{ Request::is('/orders-stats') ? 'active' : null }}" href="{{ url('/orders-stats') }}">{!! trans('titles.orders-statsNav') !!}</a>
				<a class="btn btn-success {{ Request::is('/partners') ? 'active' : null }}" href="{{ url('/partners') }}">{!! trans('titles.partnersNav') !!}</a>
			@endrole
			@role('user')
				<p class="text-center">Ожидайте, <strong>Администратор</strong> в ближайшее время предоставит доступ <strong>агента</strong></p>
			@endrole
		</div>			
    </div>
</div>
