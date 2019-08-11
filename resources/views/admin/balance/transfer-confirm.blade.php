@extends('adminlte::page')

@section('title', 'Transferência')

@section('content_header')
    <h1>Confirmar Transferência</h1>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h1>Confirmar Transferência Saldo</h1>
        </div>
        <div class="box-body">
          @include('admin.includes.alerts')
          <p><strong>Recebedor: </strong>{{$receiver->name}}</p>
          <p><strong>Saldo: </strong>{{$balance->amount}}</p>
            <form method="POST" action="{{ route('transfer.store') }}">
            {{csrf_field()}}
            <input type="hidden" name="receiver_id" value="{{$receiver->id}}">
                <div class="form-group">
                    <input type="text" name="value" class="form-control" placeholder="Valor">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Transferir</button>
                </div>
            </form>
        </div>
    </div>
@stop