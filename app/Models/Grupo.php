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
}
