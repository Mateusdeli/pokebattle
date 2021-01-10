<?php

namespace App\Http\Controllers;

use App\Http\Services\Battle\BattleService;
use App\Http\Services\Pokemons\PokemonService;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BattleController extends Controller
{

    private PokemonService $pokemonService;
    private BattleService $battleService;

    public function __construct(PokemonService $pokemonService, BattleService $battleService) {
        $this->pokemonService = $pokemonService;
        $this->battleService = $battleService;
    }

    public function index()
    {
        
        if(!Session::has('user_pokemon'))
        {
            return redirect()->route('painel.index');
        }
        
        $user_pokemon = Session::get('user_pokemon');
        $pokemon_enemy = $this->pokemonService->gerarPokemonAdversario(1, 110);
        Session::put('pokemon_enemy', $pokemon_enemy);

        return view('dashboard.battle.index', [
            'pokemon' => $pokemon_enemy,
            'player_pokemon' => $user_pokemon,
            'resultado_battle' => $this->battleService->battle() ? 'Você venceu a batalha!' : 'Você perdeu a batalha'
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
            return redirect()->route('painel.index')->withErrors('Voce nao possui este pokemon.');
        }

        return $request->getUri();
    }

}
