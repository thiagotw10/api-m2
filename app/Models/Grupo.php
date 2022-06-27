<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [
         'grupo'
    ];

    public function cidades(){
        return $this->hasMany(Cidade::class, 'grupo_id');
    }
    public function campanhas(){
        return $this->hasMany(Campanha::class, 'grupo_id');
    }

    public function produtos(){
        return $this->hasMany(Produto::class, 'campanha_id');
    }
}
