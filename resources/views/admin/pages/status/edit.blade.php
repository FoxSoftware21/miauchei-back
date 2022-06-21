@extends('adminlte::page')

@section('title', "Editar o status {$status->name}")

@section('content_header')
    <h1>Editar o status {{ $status->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('status.update', $status->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.pages.status._partials.form')
            </form>
        </div>
    </div>
@endsection
