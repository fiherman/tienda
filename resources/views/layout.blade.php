<!DOCTYPE html>

<html lang="us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CAJA</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <!--<link rel="stylesheet" href="{{ asset('css/estilo.css') }}"/>-->
    
    <!--JQUERY UI ui.jqgrid -->
    {!! Html::style('js/jquery_1_11_4/jquery-ui.css') !!}    
    {!! Html::style('js/jqgrid_5.0.1/css/ui.jqgrid.css') !!}
    {!! Html::style('css/estilo.css') !!}
    <!--{!! Html::style('css/bootstrap.min.css') !!}-->
</head>
<body style="background: #E5F3FA">
    <div class="navbar navbar-default">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#" class="navbar-brand"><b>BIENVENIDO AL SISTEMA</b></a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}"><b>Inicio</b></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())                       
                        <li><a href="{{ route('login') }}"><b>Iniciar Session</b></a></li>
                    @else                        
                        <li><a href="#" class="navbar-brand" ><b>{{ Auth::user()->rol }}</b></a></li>
                        <li class="dropdown">                           
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->ape_nom }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('logout') }}"><b>Salir del Sistema</b></a></li>
                            </ul>
                        </li>                        
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
	@yield('content')
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/jquery_1_11_4/external/jquery/jquery.js') }}"></script>    
        <script src="{{ asset('js/jquery_1_11_4/jquery-ui.js') }}"></script>   
        
        <script src="{{ asset('js/jqgrid_5.0.1/js/jquery.jqGrid.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('js/jqgrid_5.0.1/js/i18n/grid.locale-es.js') }}" type="text/javascript"></script>
        
        <script src="{{ asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
        
	@yield('scripts')
    <div  id="mensaje" title="MENSAJE DEL SISTEMA" style="display: none;"></div>
    <div  id="eliminar" title="MENSAJE DEL SISTEMA" style="display: none;"></div>  
    @if (!Auth::guest()) 
        <input type="hidden" id="user_rol" value="{{ Auth::user()->rol }}" >
        <input type="hidden" id="usuario_id" value="{{ Auth::user()->id }}" >
        <input type="hidden" id="usuario" value="{{ Auth::user()->ape_nom }}" >
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">

        <script>
            $(document).ready(function() {              
                llenar_combo_casas(0);
                get_data_system();//datos tablasystem
                global_usuario  = $("#usuario").val();
                global_rol      = $("#user_rol").val();
                global_user_id  = $("#usuario_id").val();
                global_token    = $("#_token").val();
                global_interes  = 0;
//                document.getElementById("dialog_load_tabla_cliente_id").addEventListener("click", get_cliente_id);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'GET',
                    url: 'get_interes',                    
                    success: function (data) {
                       global_interes = data.interes;
                    }
                });
            });
        </script>
    @endif
</body>
</html>


                                
