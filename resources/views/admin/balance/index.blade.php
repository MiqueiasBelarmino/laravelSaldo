@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <a href="{{route('balance.deposit')}}" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Recarregar</a>
            @if($amount > 0)
                <a href="{{route('balance.withdraw')}}" class="btn btn-danger"><i class="fa fa-cart-arrow-down"></i> Sacar</a>
            @endif
            @if($amount > 0)
                <a href="{{route('balance.transfer')}}" class="btn btn-info"><i class="fa fa-exchange" aria-hidden="true"></i> Transferir</a>
            @endif
        </div>
        <div class="box-body">
        @include('admin.includes.alerts')
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>R$ {{number_format($amount,2,',','')}}</h3>

                    <p></p>
                </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">Histórico<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@stop