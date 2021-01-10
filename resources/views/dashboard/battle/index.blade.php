@extends('layout.app')

@section('content')
    <div class="mt-5">
        <h3 class="text-center">Battle</h3>
        <hr>
        @if (isset($resultado_battle))
            <div>
                <p>{{$resultado_battle}}</p>
            </div>
        @endif
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-6">
                    @if (Session::has('user_pokemon'))
                        <div class="card mt-3" style="width: 25rem;">
                            <div class="row align-items-center">
                                <div class="col-6 d-flex justify-content-center">
                                    <div class="d-flex flex-column pt-3 text-center">
                                        <span><strong>{{Str::ucfirst($player_pokemon->nome)}}</strong></span>
                                        <img src="{{$player_pokemon->sprite_default}}" width="150" class="img-fluid" alt="{{$player_pokemon->nome}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                   <ul style="list-style: none" class="pl-0">
                                        @foreach ($player_pokemon->stats as $stat)
                                            <li>
                                            <div class="d-flex justify-content-between">
                                                {{$stat->stat->name}}
                                                <span class="pr-3">{{ $stat->base_stat }}</span>
                                            </div>
                                            </li>
                                        @endforeach
                                   </ul>
                                </div>
                             </div>
                        </div>
                    @endif
                </div>
                <div class="col-6">
                    <div class="card mt-3" style="width: 25rem;">
                        @include('partials.pokemon-template', (array) $pokemon)
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection