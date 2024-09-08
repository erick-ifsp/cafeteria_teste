<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'tipo',
        'valor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

}
