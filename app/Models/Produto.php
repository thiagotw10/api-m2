<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'campanha_id', 'produto', 'preco', 'preco_desconto'
    ];

    public function descontos(){
        return $this->hasMany(Desconto::class, 'produto_id');
    }
}
