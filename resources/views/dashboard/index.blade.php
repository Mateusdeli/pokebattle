@extends('layout.app')
@section('title', 'Painel')

@section('content')
   <div class="my-2 d-flex justify-content-between">
      <h5>{{ $player->name }}</h5>
      <h5>Level: {{ $player->level }}</h5>
      <span>
         <strong>{{ $player->pokeballs }}x</strong>
         <img src="{{ asset('storage/pokeballs.png') }}" width="38" class="img-fluid ml-2" alt="pokeballs" /> 
      </span>
   </div>
   <hr>
   @include('partials.error', (array) $errors)
   <div class="my-5">
      @if ($player->level <= 1)
         <h3>Escolha seu pokemon inicial:</h3>
         @foreach ($pokemons_basic as $basic)
            <div class="card mt-3" onclick="chooseBegginerPokemon('{{ $basic->getNome() }}')" style="width: 25rem;">
               <div class="row align-items-center">
                  <div class="col-6 d-flex justify-content-center">
                     <img src="{{$basic->getSpriteDefault()}}" width="150" class="img-fluid" alt="{{$basic->getNome()}}">
                  </div>
                  <div class="col-6">
                     <ul style="list-style: none" class="pl-0">
                        @foreach ($basic->getStats() as $stats)
                           <li>
                              <div class="d-flex justify-content-between">
                                 {{ $stats->stat->name }}
                                 <span class="pr-3">{{ $stats->base_stat }}</span>
                              </div>
                           </li>
                        @endforeach
                     </ul>
                  </div>
               </div>
            </div>
         @endforeach
      @else
         <h3>Seus Pokemons:</h3>
         <ul style="list-style: none" class="pl-0">
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            @foreach ($user_pokemons as $pokemon)
               <li>
                  <div data-id="{{$pokemon->nome}}" class="card mt-3" onclick="choosePokemon('{{$pokemon->id}}')" style="width: 25rem;">
                     <div class="row align-items-center">
                        <div class="col-6 d-flex justify-content-center">
                           <div class="d-flex flex-column pt-3 text-center">
                              <span><strong>{{Str::ucfirst($pokemon->nome)}}</strong></span>
                              <img src="{{$pokemon->sprite_default}}" width="150" class="img-fluid" alt="{{$pokemon->nome}}">
                          </div>
                        </div>
                        <div class="col-6">
                           <ul style="list-style: none" class="pl-0">
                              @foreach ($pokemon->stats as $stats)
                                 <li>
                                    <div class="d-flex justify-content-between">
                                       {{ $stats->stat->name }}
                                       <span class="pr-3">{{ $stats->base_stat }}</span>
                                    </div>
                                 </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      @endif
   </div>

   <script>

      function chooseBegginerPokemon(pokemon_name) {

         let dataForm = new FormData();
         dataForm.append('pokemon_name', pokemon_name);

         $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "painel",
            contentType: false,
            processData: false,
            data: dataForm,
            success: function (response) {
              window.location.href = response;
            },
            error: (e) => {}
         });
      }

      function choosePokemon(pokemon_id) {

         let csrfToken = $('meta[name="csrf-token"]').attr('content');

         let formData = new FormData();
         formData.append('pokemon_id', pokemon_id);
         formData.append('_token', csrfToken);

         $.ajax({
            type: "POST",
            url: "painel/battle",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
               window.location.href = response;
            },
            error: (e) => console.log(e)
         });
      }
   </script>

@endsection
