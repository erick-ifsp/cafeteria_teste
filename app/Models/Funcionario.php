<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nome', 
        'cpf', 
        'salario', 
        'telefone', 
        'email', 
        'cargo', 
        'data_contratacao', 
        'access_id',
        'user_id'
    ];

    public function accesses()
    {
        return $this->belongsTo(Access::class);
    }
}
