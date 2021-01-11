<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'pokeballs'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'beginner' => 'bool',
        'email_verified_at' => 'datetime',
        'pokeballs' => 'integer'
    ];

    public function pokemons()
    {
        return $this->hasMany(Pokemon::class);
    }
    
}
