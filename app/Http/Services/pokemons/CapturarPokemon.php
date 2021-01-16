<?php

namespace App\Http\Services\Pokemons;

use App\Http\Services\Pokemons\PokemonService;
use App\Jobs\Player\RemoverPokeballUser;
use App\Models\Enemy;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CapturarPokemon
{

  private PokemonService $pokemonService;
  private int $chanceMinimaDaPokeball;
  private int $chanceMaximaDaPokeball;
  private int $chanceCapturaDaPokeball;

  function __construct(PokemonService $pokemonService)
  {
      $this->pokemonService = $pokemonService;
      $this->chanceMinimaDaPokeball = 1;
      $this->chanceMaximaDaPokeball = 100;
      $this->chanceCapturaDaPokeball = 20;
  }

  public function capturar(string $pokemon_name): bool
  {
      $pokemon = $this->pokemonService->buscarPokemonPorNome($pokemon_name);
      $user_id = Auth::user()->getAuthIdentifier();
      
      RemoverPokeballUser::dispatch($user_id);
      
      if (!$this->checarPokeballQuebrou()) {
        return false;
      }

      DB::beginTransaction();
        Pokemon::create([
          'nome' => $pokemon['name'], 
          'stats' => json_encode($pokemon['stats']), 
          'sprite_default' => $pokemon['sprite_default'],
          'sprite_shiny' => $pokemon['sprite_shiny'], 
          'user_id' => $user_id
        ]);
      DB::commit();

      return true;
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

  private function checarPokeballQuebrou(): bool
  {
    $chance = random_int($this->chanceMinimaDaPokeball, $this->chanceMaximaDaPokeball);
    return $chance <= $this->chanceCapturaDaPokeball ? true : false; 
  }

}
