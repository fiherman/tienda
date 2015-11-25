
@extends('layout')

@section('content')

    @if (Auth::guest())
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Bienvenido</div>
                        <div class="panel-body">
                            <p>DEVE INICIAR SESSION PARA ABRIR EL SISTEMA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <br><br><br>
                    <div class="row clearfix" style="width: 100%"> 

                            <div class="col-md-4 column">
                                <a href="#" onclick="open_dialog_administracion('{{Auth::user()->rol}}');" class="list_group_item" style="opacity: 0.9;">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><center><h1><b>Administraci&oacute;n</b></h1></center></div>
                                    <div class="panel-body">                                                    
                                        <img src="{{ asset('images/config2.png') }}" class="img-rounded img-responsive" style="width: 58%;margin-left: 21%">                                                    
                                    </div>
                                </div>
                                </a>
                            </div>                                                                                    

                        <div class="col-md-4 column">
                            <a href="#" onclick="open_dialog_tabla_cLiente();" class="list_group_item" style="opacity: 0.9;">
                            <div class="panel panel-default">
                                <div class="panel-heading"><center><h1><b>Clientes</b></h1></center></div>
                                <div class="panel-body">                                                    
                                    <img src="{{ asset('images/clientes3.png') }}" class="img-rounded img-responsive" style="width: 58%;margin-left: 25%">                                                    
                                </div>
                            </div>
                            </a>                                            
                        </div>
                        <div class="col-md-4 column">
                            <a href="#" onclick="open_administracion();" class="list_group_item" style="opacity: 0.9;">
                            <div class="panel panel-default">
                                <div class="panel-heading"><center><h1><b>Reportes</b></h1></center></div>
                                <div class="panel-body">                                                    
                                    <img src="{{ asset('images/reporte.png') }}" class="img-rounded img-responsive" style="width: 58%;margin-left: 20%">                                                    
                                </div>
                            </div>
                            </a>                                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--VARIABLES GLOBALES QUE SE UASN EN JAVASCRIT-->
        

        <script src="{{ asset('js/metas.js') }}"></script>
        <script src="{{ asset('js/general.js') }}"></script>
        <script src="{{ asset('js/clientes.js') }}"></script>
        <script src="{{ asset('js/casa.js') }}"></script>
        <script src="{{ asset('js/prestamo.js') }}"></script>

        @include('partes/admin_dialog')
        @include('partes/vw_clientes')
        @include('partes/vw_prestamo')
    @endif

@endsection
