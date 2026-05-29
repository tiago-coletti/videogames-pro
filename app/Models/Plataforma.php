<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    use HasFactory;

    protected $table = 'plataformas';

    protected $fillable = [
        'nome',
        'fabricante',
        'ano_lancamento',
        'imagem',
        'ativo',
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
