@extends('adminlte::page')

@section('title', 'Status')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a class="breadcrumb-item active" href="{{ route('status.index') }}"
                class="active">Status</a></li>
    </ol>
    <h1>Status</h1>
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
                <form action="{{ route('status.search') }}" method="POST" class="form form-inline">
                    @csrf
                    <input type="text" name="filter" placeholder="Pesquisar" class="form-control"
                        value="{{ $filters['filter'] ?? '' }}">
                    <button type="submit" class="btn btn-dark">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
                <a href="{{ route('status.create') }}" class="btn btn-dark">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($status as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td style="display: flex; align-items: center; justify-content: space-evenly;">
                                <a href="{{ route('status.show', $item->id) }}" class="btn btn-warning" title="VER">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('status.edit', $item->id) }}" class="btn btn-info" title="EDITAR">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="display: flex; justify-content: center;">
            {!! $status->links() !!}
        </div>
    </div>
@stop
