<?php

namespace App\Http\Controllers;

use App\Http\Helper\BuscarPokemonNome;
use App\Http\Services\Pokemons\EscolherPokemonInicial;
use App\Http\Services\Pokemons\PokemonService;
use App\Jobs\PokemonInicial;
use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private $pokemonService;
    private $escolherPokemonInicial;

    public function __construct(PokemonService $pokemonService, EscolherPokemonInicial $escolherPokemonInicial) {
        $this->pokemonService = $pokemonService;
        $this->escolherPokemonInicial = $escolherPokemonInicial;
    }

    public function index(Request $request)
    {
        $user_pokemons = Pokemon::query()->where('user_id', $request->user()->id)->get();
        $escolherPokemons = $this->pokemonService->escolherPokemonInicial(['bulbasaur', 'squirtle', 'charmander']);
        return view('dashboard.index', [
            'player' => $request->user(),
            'user_pokemons' => $user_pokemons,
            'pokemons_basic' => $escolherPokemons
        ]);
    }

    public function beginnerPokemon(Request $request)
    {
       $this->escolherPokemonInicial->adicionarPokemonInicial($request->user()->id, $request->pokemon_name);
       return redirect()->route('painel.index');
    }
}
