@extends('adminlte::page')

@section('title', 'Pets Perdidos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a class="breadcrumb-item active" href="{{ route('pets.lost.index') }}"
                class="active">Pets Perdidos</a></li>
    </ol>
    <h1>Pets Perdidos</h1>
@stop

@section('content')
    <style>
        table th {
            text-align: center;
        }
        table td {
            text-align: center;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between">
                <form action="{{ route('pets.lost.search') }}" method="POST" class="form form-inline">
                    @csrf
                    <input type="text" name="filter" placeholder="Pesquisar" class="form-control"
                        value="{{ $filters['filter'] ?? '' }}">
                    <button type="submit" class="btn btn-dark">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
                <a href="{{ route('pets.lost.create') }}" class="btn btn-dark">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
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
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $item)
                        <tr>
                            <td><img width="30px" height="30px" src="{{ $item->foto }}" alt="Foto do Pet"></td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->especie }}</td>
                            <td>{{ $item->sexo }}</td>
                            <td>{{ $item->raca }}</td>
                            <td>{{ $item->tamanho }}</td>
                            <td>{{ $item->cor_predominante }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->data_desaparecimento)) }}</td>
                            <td style="display: flex; align-items: center; justify-content: space-evenly;">
                                <a href="{{ route('pets.show', $item->id) }}" class="btn btn-warning" title="VER">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>

                                <a href="{{ route('pets.edit', $item->id) }}" class="btn btn-info" title="EDITAR">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#avistado{{ $item->id }}" title="AVISTADO">
                                    <i class="fas fa-chart-line"></i>
                                </button>

                                <a href="{{ route('pets.lost.found', $item->id) }}" class="btn btn-success"
                                    title="ENCONTRADO">
                                    <i class="fas fa-search-location"></i>
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

    {{-- MODAL --}}
    @foreach ($pets as $item)
        <div class="modal fade" id="avistado{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pet avistado</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('avistamentos.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="pet_id" class="form-control" value="{{ $item->id }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="last_seen" class="form-label">Última vez visto:</label>
                                <input type="text" name="ultima_vez_visto" class="form-control" id="last_seen"
                                    placeholder="Rua">
                            </div>

                            <div class="mb-3">
                                <label for="data_sighted" class="form-label">Avistado:</label>
                                <input type="date" name="data_avistamento" class="form-control" id="data_sighted"
                                    placeholder="Rua">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@stop
