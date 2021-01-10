@extends('layout.app')
@section('title', 'Registrar')

@section('content')

    <div class="container d-flex justify-content-center align-items-center">
        <div class="w-50">
            <h1 class="my-4 text-center">Registro</h1>
            @include('partials.success')
            @include('partials.error')
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
@endsection