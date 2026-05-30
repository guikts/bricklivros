<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
    'livro_id', 
    'user_id', 
    'data_emprestimo', 
    'data_limite_devolucao', 
    'data_devolucao',
    'valor_multa',     
    'status_multa'     
];
}