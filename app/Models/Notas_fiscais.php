<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas_fiscais extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'user_id',
        'nome',
        'cpf',
        'endereco',
        'valor_total',
        'forma_pagamento',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
