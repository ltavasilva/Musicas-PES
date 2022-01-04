<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Bootstrap CSS -->
        <link href="{{ asset('asset/customBootstrap.css') }}" rel="stylesheet">
        
        <title>@yield('title')</title>
        
        @yield('customHead')

        <style type="text/css">
            body {
                padding-top: 5rem;
            }
            
            .tituloCard {
            	background-color: #80808059;
            	border-radius: 5px;
            	padding: 1px;
            	text-align: center;
            	vertical-align: baseline;
            }
            
            .commandCard {
            	display: flex;
                margin-bottom: 10px;
            }
            .actionCard {
            	display: grid;
                float: right;
            }
            .actionCard a {
            	margin-left: 10px;
            }
            
            .rowRef {
            	vertical-align: middle;
            }
            
            .card {
            	background-color: #ffffff2e;
            }
            .musicaInfo .card-subtitle{display: -webkit-box;}
            .musicaInfo .detail{margin-top: 7px;}
            .musicaInfo h4 p, h7 p{margin-left: 5px;}

            .nav-item-min{margin-right: 5px;}

            .feather16 {
                width: 16px;
                height: 16px;
                stroke: currentColor;
                stroke-width: 2;
                stroke-linecap: round;
                stroke-linejoin: round;
                fill: none;
            }

            select[readonly] {
                pointer-events: none;
                touch-action: none;
            }

            #slidesHtml{background-color: #000;}

            .actionLetra{margin-top: 10px;}
            .btnUpDown{text-align: center; width: 100%; margin-top: 10px;}
            .btnUpDown svg{text-align: center; width: 50px; color: #0a58ca;}

            .spinner {
				z-index: 1050;
				text-align: center;
				position: fixed;
				left: 0;
				top: 0;
				right: 0;
				bottom: 0;
				padding-top: calc(50vh - 20px);
				background: #0000009c;
			}

            .ocultar{display: none !important;}         
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-xl navbar-dark bg-dark fixed-top">
                <a class="navbar-brand" href="{{url("")}}">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav bd-navbar-nav">
                        {{ setMenu()}}
                    </ul>

                    <ul class="navbar-nav ml-md-auto d-md-flex">
                        <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
    
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                        
                    </ul>
                    {{-- <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> --}}
                </div>
            </nav>
        </div>
        
@yield('content')
    	<script src="{{ asset('asset/jquery.js') }}"></script>
    	<script src="{{ asset('asset/bootstrap.js') }}"></script>
    	<script src="{{ asset('asset/icons/feather.min.js') }}"></script>
    	<script type="text/javascript">
            feather.replace();            
    		$(".hide").hide();
@yield('javaScript')
            	
        </script>
    </body>
</html>