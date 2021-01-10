<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enemy
{
    
    private string $nome;
    private array $stats;
    private string $sprite_default;
    private string $sprite_shiny;

    public function __construct($nome, $stats, $sprite_default, $sprite_shiny) {
        $this->nome = $nome;
        $this->stats = $stats;
        $this->sprite_default = $sprite_default;
        $this->sprite_shiny = $sprite_shiny;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getSpriteDefault(): string
    {
        return $this->sprite_default;
    }

    public function getSpriteShiny(): string
    {
        return $this->sprite_shiny;
    }

    public function setNome($nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function setStats($stats): self
    {
        $this->stats = $stats;
        return $this;
    }

    public function setSpriteDefault($sprite_default): self
    {
        $this->sprite_default = $sprite_default;
        return $this;
    }

    public function setSpriteShiny($sprite_shiny): self
    {
        $this->sprite_shiny = $sprite_shiny;
        return $this;
    }

}
