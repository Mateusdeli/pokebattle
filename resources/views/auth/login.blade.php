@extends('layout.app')
@section('title', 'Login')

@section('content')
    <div class="w-50" style="margin: 0 auto">
        <h1 class="my-4 text-center">Login</h1>
        @include('partials.error')
        @include('partials.success')
        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            <a href="{{ route('register.index') }}" class="btn btn-dark">Registrar</a>
        </form>
    </div>
@endsection
