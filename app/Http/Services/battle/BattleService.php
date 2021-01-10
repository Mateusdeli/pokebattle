<?php

namespace App\Http\Services\Battle;

use App\Http\Services\Pokemons\PokemonService;
use App\Models\Enemy;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Session;

class BattleService
{

    private PokemonService $pokemonService;

    public function __construct(PokemonService $pokemonService) {
        $this->pokemonService = $pokemonService;
    }

    public function battle(): bool
    {
        $user_pokemon = Session::get('user_pokemon');
        $enemy_pokemon = Session::get('pokemon_enemy');
        $attack_enemy = $this->pokemonService->converterStatsPokemon($enemy_pokemon);
        $attack_player = $this->pokemonService->converterStatsPokemon($user_pokemon);
        return $this->calcularDanoBattle($attack_player, $attack_enemy);
    }

    private function calcularDefesa(int $pokemon_hp_stat, int $pokemon_def_stat)
    {
        return $pokemon_hp_stat + ($pokemon_def_stat * ($pokemon_def_stat / 100));
    }

    private function calcularDanoBattle(array $attack_player, array $attack_enemy): bool
    {
        $pokemon_enemy_vitality = $this->calcularDefesa($attack_enemy[0]->base_stat, $attack_enemy[2]->base_stat);
        $pokemon_player_attack = $attack_player[1]->base_stat;

        if ($pokemon_player_attack >= $pokemon_enemy_vitality) {
            return true;
        }
        else {
            return false;
        }
    }

}