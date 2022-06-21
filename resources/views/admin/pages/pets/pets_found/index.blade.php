@extends('adminlte::page')

@section('title', 'Pets Encontrados')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a class="breadcrumb-item active" href="{{ route('pets.found.index') }}"
                class="active">Pets Encontrados</a></li>
    </ol>
    <div style="display: flex; justify-content: space-between">
        <h1>Pets Encontrados</h1>
    </div>

@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('pets.found.search') }}" method="POST" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Pesquisar" class="form-control"
                    value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Espécie</th>
                        <th>Sexo</th>
                        <th>Raça</th>
                        <th>Tamanho</th>
                        <th>1° Cor</th>
                        <th>Desap.</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $item)
                        <tr>
                            <td><img width="30px" height="30px" src="{{ $item->photo }}" alt="Foto do Pet"></td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->especie }}</td>
                            <td>{{ $item->sexo }}</td>
                            <td>{{ $item->raca }}</td>
                            <td>{{ $item->tamanho }}</td>
                            <td>{{ $item->cor_predominante }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->data_desaparecimento)) }}</td>
                            <td style="width=10px;">
                                <a href="{{ route('pets.show', $item->id) }}" class="btn btn-warning" title="VER">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="{{ route('pets.edit', $item->id) }}" class="btn btn-info" title="EDITAR">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <a href="{{ route('pets.found.lost', $item->id) }}" class="btn btn-danger"
                                    title="PERDIDO">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="display: flex; justify-content: center;">
            {!! $pets->links() !!}
        </div>
    </div>
@stop
