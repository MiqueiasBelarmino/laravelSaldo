@extends('adminlte::page')

@section('title', 'Transferência')

@section('content_header')
    <h1>Efetuar transferência</h1>
@stop

@section('content')
<div class="box">
        <div class="box-header">
            <h1>Transferir (Informe o recebedor)</h1>
        </div>
        <div class="box-body">
          @include('admin.includes.alerts')
            <form method="POST" action="{{ route('confirm.transfer') }}">
            {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="receiver" class="form-control" placeholder="Informação do usuário recebedor (nome ou e-mail)">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Próxima etapa</button>
                </div>
            </form>
        </div>
    </div>
@stop