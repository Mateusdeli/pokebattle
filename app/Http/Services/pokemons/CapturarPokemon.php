<?php

namespace App\Http\Services\Pokemons;

use App\Http\Services\Pokemons\PokemonService;
use App\Jobs\Player\RemoverPokeballUser;
use App\Models\Enemy;
use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CapturarPokemon
{

  private PokemonService $pokemonService;

  function __construct(PokemonService $pokemonService)
  {
      $this->pokemonService = $pokemonService;
  }

  public function capturar(string $pokemon_name): void
  {
      $pokemon = $this->pokemonService->buscarPokemonPorNome($pokemon_name);
      $user_id = Auth::user()->getAuthIdentifier();
      Pokemon::create([
        'nome' => $pokemon['name'], 
        'stats' => json_encode($pokemon['stats']), 
        'sprite_default' => $pokemon['sprite_default'],
        'sprite_shiny' => $pokemon['sprite_shiny'], 
        'user_id' => $user_id
      ]);
      RemoverPokeballUser::dispatch($user_id);
  }

  public function checarPlayerPodeCapturar(Enemy $pokemonEnemy)
  {
    $user_id = Auth::user()->getAuthIdentifier();
    $player_pokemons = Pokemon::where('user_id', $user_id)->get();

    foreach ($player_pokemons as $pokemon) {
      if ($pokemon->nome === $pokemonEnemy->getNome()) {
        return false;
      }
    }

    return true;
  }

}
