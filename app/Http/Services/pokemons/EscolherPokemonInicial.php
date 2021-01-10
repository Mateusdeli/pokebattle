<?php

namespace App\Http\Services\Pokemons;

use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EscolherPokemonInicial
{

    private PokemonService $pokemonService;

    public function __construct(PokemonService $pokemonService) {
        $this->pokemonService = $pokemonService;
    }
    
    public function adicionarPokemonInicial(int $id_player, string $pokemon_name)
    {
        $pokemon = $this->pokemonService->buscarPokemonPorNome($pokemon_name);
        DB::beginTransaction();
            Pokemon::create([
                'nome' => $pokemon['name'],
                'stats' => json_encode($pokemon['stats']),
                'sprite_default' => $pokemon['sprite_default'],
                'sprite_shiny' => $pokemon['sprite_shiny'],
                'user_id' => $id_player
            ]);
            User::where('id', $id_player)->update([
                'level' => 2
            ]);
        DB::commit();
    }

}
