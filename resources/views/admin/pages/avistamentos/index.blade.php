@extends('adminlte::page')

@section('title', 'Avistamentos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a class="breadcrumb-item active" href="{{ route('avistamentos.index') }}"
                class="active">Avistamentos</a></li>
    </ol>
    <h1>Avistamentos</h1>
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
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Dono</th>
                        <th>Espécie</th>
                        <th>Desap.</th>
                        <th>Status</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>
                                <img width="30px" height="30px" src="{{ $item->foto }}" alt="{{ $item->foto }}">
                            </td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->dono }}</td>
                            <td>{{ $item->especie }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->data_desaparecimento)) }}</td>
                            @if ($item->status_id == 1)
                                <td class="text-danger">{{ $item->status }}</td>
                            @else
                                <td class="text-success">{{ $item->status }}</td>
                            @endif
                            <td style="display: flex; align-items: center; justify-content: space-evenly;">
                                <form action="{{ route('avistamentos.show', $item->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" title="AVISTAMENTOS">
                                        {{ $item->count }} <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
