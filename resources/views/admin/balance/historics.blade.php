@extends('adminlte::page')

@section('title', 'Histórico')

@section('content_header')
    <h1>Histórico de Movimentações</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <form action="{{route('historic.search')}}" method="POST" class="form form-inline">
                {!! csrf_field()!!}
                <input type="text" name="id" class="form-control" placeholder="ID">
                <input type="date" name="date" class="form-control" placeholder="Data">
                <select name="type" class="form-control">
                    <option value="">-- Selecione --</option>
                    @foreach($types as $key => $type)
                        <option value="{{$key}}">{{$type}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Receiver</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($historics as $historic)
                    <tr>
                        <td>{{$historic->id}}</td>
                        <td>{{number_format($historic->amount,2,'.',',')}}</td>
                        <td>{{$historic->type($historic->type)}}</td>
                        <td>{{$historic->date}}</td>
                        <td>
                            @if($historic->user_id_transaction)
                                {{$historic->userReceiver->name}}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            <!-- não perder o filtro na paginação -->
            @if(isset($dataForm))
                {!! $historics->appends($dataForm)->links() !!}
            @else
                {!! $historics->links()!!}
            @endif
        </div>
    </div>
@stop