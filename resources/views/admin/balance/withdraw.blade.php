@extends('adminlte::page')

@section('title', 'Saque')

@section('content_header')
    <h1>Efetuar saque</h1>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h1>Sacar</h1>
        </div>
        <div class="box-body">
          @include('admin.includes.alerts')
            <form method="POST" action="{{ route('withdraw.store') }}">
            {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="value" class="form-control" placeholder="Valor do saque">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sacar</button>
                </div>
            </form>
        </div>
    </div>
@stop