<?php

namespace App\Http\Services\Pokemons;

use App\Models\Enemy;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    
    public function escolherPokemonInicial(array $pokemons)
    {
        $pokemons_basic = [];

        foreach ($pokemons as $pokemon) {
            $pokemon = strtolower($pokemon);
            $json = json_decode(Http::get("https://pokeapi.co/api/v2/pokemon/$pokemon")->body());
            $stats = $this->converterStatsPokemon($json);
            $pokemons_basic[] = new Enemy($json->name, $stats, $json->sprites->front_default,$json->sprites->front_shiny);
            
        }
        return $pokemons_basic;
    }

    public function converterStatsPokemon(object $stats): array 
    {
        $not_allow_stats = ['special-attack', 'special-defense'];
        $filtred = [];

        if ($stats instanceof Enemy) {
            foreach ($stats->getStats() as $stat) {
                if (!in_array($stat->stat->name, $not_allow_stats)) {
                    $filtred[] = $stat;
                }
            }
        }
        else {

            foreach ($stats->stats as $stat) {
                if (!in_array($stat->stat->name, $not_allow_stats)) {
                    $filtred[] = $stat;
                }
            }
        }

        return $filtred;
    }

    public function buscarPokemonPorNome($pokemon)
    {
        $json = json_decode(Http::get("https://pokeapi.co/api/v2/pokemon/$pokemon")->body());
        $pokemon = [
            'name' => $json->name,
            'stats' => $this->converterStatsPokemon($json),
            'sprite_default' => $json->sprites->front_default,
            'sprite_shiny' => $json->sprites->front_shiny
        ];
        
        return $pokemon;
    }

    public function gerarPokemonAdversario(int $min_range, int $max_range)
    {
        $random = rand($min_range, $max_range);
        $json = json_decode(Http::get("https://pokeapi.co/api/v2/pokemon/$random")->body());
        $stats = $this->converterStatsPokemon($json);
        $enemy = new Enemy($json->name, $stats, $json->sprites->front_default,$json->sprites->front_shiny);
        return $enemy;
    }


}