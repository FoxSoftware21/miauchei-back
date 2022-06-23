@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <style>
        a,
        a:hover,
        a:focus,
        a:active {
            text-decoration: none;
            color: inherit;
        }

        .info-box:hover {
            background: #007bff;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('users.index') }}" class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fas fa-users"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Usuários</span>
                    <span class="info-box-number">{{ $counts['users'] }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('pets.lost.index') }}" class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fas fa-paw"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Pets</span>
                    <span class="info-box-number">{{ $counts['pets'] }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('pets.lost.index') }}" class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fas fa-paw"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Pets Perdidos</span>
                    <span class="info-box-number">{{ $counts['pets_lost'] }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('pets.found.index') }}" class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fas fa-paw"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Pets Encontrados</span>
                    <span class="info-box-number">{{ $counts['pets_found'] }}</span>
                </div>
            </a>
        </div>

    </div>
@endsection
