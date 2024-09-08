<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'preco',
        'categoria',
        'tipos',
        'descricao',
        'produto_arquivo',
        'produto_arquivo2',
        'produto_arquivo3',
        'produto_arquivo4'
    ];

    use HasFactory;
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function carrinho()
    {
        return $this->hasMany(Carrinho::class);
    }
}
