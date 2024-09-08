<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'metodo_pagamento',
        'created_at',
        'updated_at',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pedidoProdutos()
    {
        return $this->hasMany(PedidoProduto::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedido_produtos')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
