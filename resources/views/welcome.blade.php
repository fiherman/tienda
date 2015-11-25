@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">REGISTRO</div>
                <div class="panel-body">
                    <p>hay {{ $users->total() }} usuarios</p>
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Usuario</th>                            
                        </tr>
                        @foreach( $users as $user)
                        <tr>
                            <th>{{ $user->id }}</th>
                            <th>{{ $user->name }}</th>
                            <th>{{ $user->user }}</th>                            
                        </tr>
                        @endforeach
                    </table>
                    {!! $users->render() !!}
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
