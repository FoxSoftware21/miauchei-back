@extends('adminlte::page')

@section('title', "Detalhes do status {$status->name}")

@section('content_header')
    <h1>Detalhes do status <b>{{ $status->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Status: </strong> {{ $status->name }}
                </li>
            </ul>

            <form action="{{ route('status.destroy', $status->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash" title="DELETAR"></i> DELETAR O STATUS
                    <b>{{ $status->name }}</b>
                </button>
            </form>
        </div>
    </div>
@endsection
