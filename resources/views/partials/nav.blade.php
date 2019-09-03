<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {!! config('app.name', trans('titles.app')) !!}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="navbar-nav mr-auto">
                @role('admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}" href="{{ url('/users') }}">
                                {!! trans('titles.adminUserList') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}" href="{{ url('/users/create') }}">
                                {!! trans('titles.adminNewUser') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('themes','themes/create') ? 'active' : null }}" href="{{ url('/themes') }}">
                                {!! trans('titles.adminThemesList') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                                {!! trans('titles.adminLogs') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}" href="{{ url('/activity') }}">
                                {!! trans('titles.adminActivity') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}" href="{{ url('/phpinfo') }}">
                                {!! trans('titles.adminPHP') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}" href="{{ url('/routes') }}">
                                {!! trans('titles.adminRoutes') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}" href="{{ url('/active-users') }}">
                                {!! trans('titles.activeUsers') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}" href="{{ route('laravelblocker::blocker.index') }}">
                                {!! trans('titles.laravelBlocker') !!}
                            </a>
                        </div>
                    </li>
                @endrole
				@role('admin')
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Operator
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item {{ Request::is('orders-all') ? 'active' : null }}" href="{{ url('/orders-all') }}">{!! trans('titles.orders-allNav') !!}</a>
							<a class="dropdown-item {{ Request::is('agents-all') ? 'active' : null }}" href="{{ url('/agents-all') }}">{!! trans('titles.agents-allNav') !!}</a>							
                        </div>
                    </li>				
				@endrole
				@if (Auth::user() && Auth::user()->hasRole(['operator']))
					<li><a class="nav-link {{ Request::is('orders-all') ? 'active' : null }}" href="{{ url('/orders-all') }}">{!! trans('titles.orders-allNav') !!}</a></li>
					<li><a class="nav-link {{ Request::is('agents-all') ? 'active' : null }}" href="{{ url('/agents-all') }}">{!! trans('titles.agents-allNav') !!}</a></li>
				@endif
				@if (Auth::user() && Auth::user()->hasRole(['admin', 'agent']))
					<li><a class="nav-link {{ Request::is('orders/create') ? 'active' : null }}" href="{{ url('orders/create') }}">{!! trans('titles.agentNewOrder') !!}</a></li>
					<li><a class="nav-link {{ Request::is('orders') ? 'active' : null }}" href="{{ url('/orders') }}">{!! trans('titles.orderDropdownNav') !!}</a></li>
					<li><a class="nav-link {{ Request::is('orders-stats') ? 'active' : null }}" href="{{ url('/orders-stats') }}">{!! trans('titles.orders-statsNav') !!}</a></li>
					<li><a class="nav-link {{ Request::is('partners') ? 'active' : null }}" href="{{ url('/partners') }}">{!! trans('titles.partnersNav') !!}</a></li>	
				@endif				
            </ul>
            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                {{-- Authentication Links --}}
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ trans('titles.login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ trans('titles.register') }}</a></li>
                @else
					<li><a class="nav-link {{ Request::is('support') ? 'active' : null }}" href="{{ url('/support') }}">{!! trans('titles.supportNav') !!}</a></li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
							@role('admin')
							<a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}">
                                {!! trans('titles.profile') !!}
                            </a>
							<div class="dropdown-divider"></div>
							@endrole
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Выйти') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
