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

    public function pedidoProdutos()
    {
        return $this->hasMany(PedidoProduto::class, 'produto_id');
    }

    public function variacoes()
    {
        return $this->hasMany(Variacao::class);
    }
}