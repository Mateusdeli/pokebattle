@extends('mails.template')
@section('content-email')
    <p>Olá {{$nome}}, por favor verifique o seu email clicando no link abaixo.</p>
    <a class="btn btn-danger" href="{{$url}}">Verificar</a>
@endsection