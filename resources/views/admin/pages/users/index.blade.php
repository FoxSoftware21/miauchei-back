@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a class="breadcrumb-item active" href="{{ route('users.index') }}"
                class="active">Usuários</a></li>
    </ol>
    <h1>Usuários</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between">
                <form action="{{ route('users.search') }}" method="POST" class="form form-inline">
                    @csrf
                    <input type="text" name="filter" placeholder="Pesquisar" class="form-control"
                        value="{{ $filters['filter'] ?? '' }}">
                    <button type="submit" class="btn btn-dark">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>

                <a href="{{ route('users.create') }}" class="btn btn-dark">
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
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><img width="30px" height="30px" src="{{ $user->photo }}" alt="{{ $user->photo }}">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td style="width=10px;">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning" title="VER">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info" title="EDITAR">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="display: flex; justify-content: center;">
            {!! $users->links() !!}
        </div>
    </div>
@stop
