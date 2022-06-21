@extends('adminlte::page')

@section('title', 'Cadastrar Novo Status')

@section('content_header')
    <h1>Cadastrar Novo Status</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('status.store') }}" class="form" method="POST">
                @csrf

                @include('admin.pages.status._partials.form')
            </form>
        </div>
    </div>
@endsection
