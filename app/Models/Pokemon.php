<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'stats', 'sprite_default', 'sprite_shiny', 'user_id'];

    protected $table = 'pokemons';
    protected $hidden = ['user_id'];
    protected $perPage = 6;
    protected $casts = [
        'nome' => 'string',
        'sprite_default' => 'string',
        'sprite_shiny' => 'string',
        'user_id' => 'integer'
    ];

    public $timestamps = false;

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function getStatsAttribute($value)
    {
        return json_decode($value);
    }

}
