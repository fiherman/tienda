@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('auth.title_ini_ses')</div>
                <div class="panel-body">
                    @include('partes/error')

                    <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">@lang('validation.attributes.user')</label>
                                <div class="col-md-6">
                                    {!! Form::text('usuario',null,['class'=>'form-control','style'=>'text-transform: uppercase']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">@lang('validation.attributes.password')</label>
                                <div class="col-md-6">
                                     {!! Form::password('password',['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Recordar mis Datos
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">INICIAR SESSION</button>
                                    <a href="/password/email">Olvisate tu Password?</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
