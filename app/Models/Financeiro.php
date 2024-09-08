<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'tipo',
        'valor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
