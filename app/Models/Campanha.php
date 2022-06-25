<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campanha extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id', 'campanha', 'status', 'descricao', 'url_imagem'
    ];

    public function produtos(){
        return $this->hasMany(Produto::class, 'campanha_id');
    }
}
