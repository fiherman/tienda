@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">REGISTRO</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="registro">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('validation.attributes.name')</label>
                            <div class="col-md-6">
                                {!! Form::text('name', null,['class'=>'form-control', 'style'=>'text-transform: uppercase']) !!}
                            </div>
                        </div>                         
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('validation.attributes.user')</label>
                            <div class="col-md-6">                                
                                {!! Form::text('user', null,['class'=>'form-control', 'style'=>'text-transform: uppercase']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('validation.attributes.fono')</label>
                            <div class="col-md-6">
                                <!--<input type="text" maxlength="15" placeholder="MAXIMO 15 CARACTERES" style="text-transform: uppercase" class="form-control" name="fono" value="{{ old('fono') }}">-->
                                {!! Form::number('fono',NULL,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('validation.attributes.password')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('validation.attributes.confirm_pass')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">REGISTRARSE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection