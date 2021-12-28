<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('img/iccmlogo.png')}}" alt="{{config('app.name')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent" >
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('about') }}">About</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('schedule') }}">Schedule <span class="sr-only">(current)</span></a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('registration') }}"><b>Registration</b> </a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('directions') }}">Directions</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('visa') }}">VISA</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ route('contact') }}">Contact</a>
						  </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto ">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('group') }}">{{ __('Your booking') }}</a>
									@if(Auth::user()->role == 'admin')
									<a class="dropdown-item" href="{{ route('admin') }}">{{ __('Admin area') }}</a>
									@endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            @yield('content')
        </main>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 iccmfooter">
					ICCM-Africa is being hosted by <a href="https://kingdomit.nl">KingdomIT Foundation</a>. See also our <a href="{{ asset('pdf/privacy.pdf') }}">privacy policy</a>.
				</div>
			</div>
		</div>
        
    </div>
</body>
</html>
