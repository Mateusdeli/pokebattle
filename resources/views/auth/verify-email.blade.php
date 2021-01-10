@extends('layout.app')

@section('content')
    <div>
        <p>Here</p>
        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit">Reenviar</button>
        </form>
    </div>
@endsection
