<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    
    protected $table = 'livros';

    /**
     * 
     * 
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',                 
        'autor',                  
        'isbn',                   
        'categoria',              
        'total_exemplares',       
        'exemplares_disponiveis', 
    ];
}