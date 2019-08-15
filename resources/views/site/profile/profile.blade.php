@extends('site.layouts.app');

@section('title', 'Meu Perfil')

@section('content')

    <h1>Meu Perfil</h1>
    @include('admin.includes.alerts')
    <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
    {!!csrf_field()!!}
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control" placeholder="Nome Completo">
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" value="{{auth()->user()->email}}" class="form-control" placeholder="E-mail">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="text" name="password" class="form-control" placeholder="Senha">
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            @if(auth()->user()->image != null)
                <img src="{{url('storage/users/'.auth()->user()->image)}}" alt="{{auth()->user()->name}}" style="max-width: 100px;">
            @endif
            
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Atualizar Perfil</button>
        </div>
    </form>

@endsection