@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="container">
                        <h1>Painel do Administrador</h1>
                        <p>Bem-vindo, {{ auth()->user()->name }}! Você está logado como <strong>Admin</strong>.</p>
                    </div>
                </div>
            </div>
            {{-- <nav>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.pedidos.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart me-2"></i>Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/products" class="nav-link">
                        <i class="fas fa-box me-2"></i>Produtos
                    </a>
                </li>
            </ul>
        </nav> --}}
        @endsection
