@extends('adminlte::page')

@section('title', 'Cadastrar Novo Pet Perdido')

@section('content_header')
    <h1>Cadastrar Novo Pet Perdido</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pets.lost.store') }}" class="form" method="POST"
                enctype="multipart/form-data">
                @csrf

                @include('admin.pages.pets._partials.form')
            </form>
        </div>
    </div>
@endsection
