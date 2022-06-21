@extends('adminlte::page')

@section('title', "Editar o Pet Encontrado {$pet->nome}")

@section('content_header')
    <h1>Editar o Pet Encontrado {{ $pet->nome }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pets.update', $pet->id) }}" class="form" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.pages.pets._partials.form')
            </form>
        </div>
    </div>
@endsection
