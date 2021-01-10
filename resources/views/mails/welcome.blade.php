@extends('mails.template')
@section('content-email')
    <div>
        <h5>Seja bem-vindo(a) {{$player->name}}!</h5>
        <p>Aqui você irá se aventurar pelo mundo pokemon.</p>
    </div>
@endsection