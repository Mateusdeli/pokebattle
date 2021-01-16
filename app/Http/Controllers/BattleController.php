<?php

namespace App\Http\Controllers;

use App\Http\Services\Battle\BattleService;
use App\Http\Services\Pokemons\{PokemonService, CapturarPokemon};
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BattleController extends Controller
{

    private PokemonService $pokemonService;
    private BattleService $battleService;
    private CapturarPokemon $capturarPokemon;

    public function __construct(PokemonService $pokemonService, BattleService $battleService, CapturarPokemon $capturarPokemon) {
        $this->pokemonService = $pokemonService;
        $this->battleService = $battleService;
        $this->capturarPokemon = $capturarPokemon;
    }

    public function index(Request $request)
    {
        $find_pokemon_range_min = 1;
        $find_pokemon_range_max = 120;

        if(!Session::has('user_pokemon'))
        {
            return redirect()->route('painel.index');
        }

        $user_pokemon = Session::get('user_pokemon');
        $pokemon_enemy = $this->pokemonService->gerarPokemonAdversario($find_pokemon_range_min, $find_pokemon_range_max);
        Session::put('pokemon_enemy', $pokemon_enemy);

        $resultadoBattle = $this->battleService->battle();
        $playerPodeCapturarPokemon = $this->capturarPokemon->checarPlayerPodeCapturar($pokemon_enemy);

        return view('dashboard.battle.index', [
            'player' => $request->user(),
            'pokemon' => $pokemon_enemy,
            'player_pokemon' => $user_pokemon,
            'podeCapturar' => $playerPodeCapturarPokemon,
            'resultado_battle' => $resultadoBattle
        ]);

    }

    public function userPokemon(Request $request)
    {
        $this->validate($request, [
            'pokemon_id' => 'required|integer',
        ]);

        $user_pokemon = Pokemon::find($request->pokemon_id);
        if (!is_null($user_pokemon)) {
            $request->session()->flash('user_pokemon', $user_pokemon);
        }
        else {
            return redirect()->route('painel.index');
        }

        return $request->getUri();
    }

    public function catchPokemon(Request $request)
    {

      $this->validate($request, [
          'pokemon_name' => 'required|string'
      ]);

      $pokemon_name = $request->pokemon_name;
      $this->capturarPokemon->capturar($pokemon_name);
      return response(['message' => "Parabéns, você capturou o pokemon {$pokemon_name}", 'redirect' => $request->route('painel.index')]);

    }

}
