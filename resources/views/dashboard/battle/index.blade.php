@extends('layout.app')

@section('content')
    <div class="mt-5">
        <h3 class="text-center">Battle</h3>
        <hr>
        @if (isset($resultado_battle))
          <div class="text-center">
              @if ($resultado_battle === true)
                  <p id="message">Você venceu a batalha!</p>
              @else
                  <p>Você perdeu a batalha!</p>
              @endif
              <a class="btn btn-danger" href="{{ route('painel.index') }}">Voltar</a>
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
                     @if ($resultado_battle === true && $player->pokeballs > 0)
                       <div class="text-center my-3">
                           @if ($podeCapturar)
                            <button class="btn btn-primary" id="capturar">Capturar</button>
                           @else
                            <button disabled class="btn btn-dark">Pokemon Já Capturado</button>
                           @endif
                       </div>
                     @endif
                </div>
            </div>
        </div>
    </div>
    <script>

        $('#capturar').click(() => {
            let token = $("meta[name='csrf-token']").attr('content');
            let url = window.location.href + '/capturar';
            let pokemon_name = "{{ $pokemon->getNome() }}";
            let formData = new FormData();
            formData.append('pokemon_name', pokemon_name);
            formData.append('_token', token);
            $.ajax({
                method: 'POST',
                url: url,
                processData: false,
                contentType: false,
                data: formData
              })
              .then(response => {
                  let message = $('#message');
                  message.addClass('alert alert-success');
                  message.text(response.message);
                  setTimeout(() => {
                    window.location.href = "{{ route('painel.index') }}";
                  }, 1000);
              })
              .catch(error => {
                console.log(error);
              });
        });

    </script>
@endsection
