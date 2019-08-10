@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Efetuar Recarga</h1>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h1>Efetuar Recarga</h1>
        </div>
        <div class="box-body">
          @include('admin.includes.alerts')
            <form method="POST" action="{{ route('deposit.store') }}">
            {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="value" class="form-control" placeholder="Valor da recarga">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Recarregar</button>
                </div>
            </form>
        </div>
    </div>
@stop