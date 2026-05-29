<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'preco_promocional',
        'estoque',
        'imagem',
        'tipo',
        'classificacao_etaria',
        'desenvolvedora',
        'distribuidora',
        'data_lancamento',
        'destaque',
        'ativo',
        'categoria_id',
        'plataforma_id',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'preco_promocional' => 'decimal:2',
        'data_lancamento' => 'date',
        'destaque' => 'boolean',
        'ativo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class);
    }

    public function pedidoItens()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function getPrecoFinalAttribute()
    {
        return $this->preco_promocional ?? $this->preco;
    }

    public function getTemPromocaoAttribute()
    {
        return !is_null($this->preco_promocional) && $this->preco_promocional < $this->preco;
    }
}
