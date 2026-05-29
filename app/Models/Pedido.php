<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'numero',
        'cliente_id',
        'status',
        'subtotal',
        'desconto',
        'frete',
        'total',
        'forma_pagamento',
        'observacoes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'desconto' => 'decimal:2',
        'frete' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public static $statusLabels = [
        'pendente'   => 'Pendente',
        'confirmado' => 'Confirmado',
        'enviado'    => 'Enviado',
        'entregue'   => 'Entregue',
        'cancelado'  => 'Cancelado',
    ];

    public static $statusColors = [
        'pendente'   => 'warning',
        'confirmado' => 'info',
        'enviado'    => 'primary',
        'entregue'   => 'success',
        'cancelado'  => 'danger',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return self::$statusColors[$this->status] ?? 'secondary';
    }
}
