@extends('adminlte::page')

@section('title', "Avistamentos $pet->nome")

@section('content_header')
    <h1>Avistamentos <b>{{ $pet->nome }}</b></h1>
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
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Animal</th>
                        <th>Quem avistou</th>
                        <th>Local</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($avistamentos as $item)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($item->data_avistamento)) }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->userAvistou }}</td>
                            <td>{{ $item->ultima_vez_visto }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
