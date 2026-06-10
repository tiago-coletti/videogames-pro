<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #252a38; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #13161f; }
        .date { font-size: 10px; color: #6c7a96; text-align: right; margin-top: -15px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th { background-color: #1a1e2a; color: #00d4ff; text-align: left; padding: 8px; font-size: 11px; text-transform: uppercase; }
        .table td { padding: 8px; border-bottom: 1px solid #252a38; }
        .table tr:nth-child(even) { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .status { text-transform: uppercase; font-weight: bold; font-size: 10px; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">{{ $titulo }}</div>
    <div class="date">Gerado em: {{ date('d/m/Y H:i') }}</div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Número</th>
            <th>Cliente</th>
            <th>Forma Pagamento</th>
            <th>Status</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $p)
        <tr>
            <td>{{ $p->numero }}</td>
            <td>{{ $p->cliente->nome }}</td>
            <td style="text-transform: capitalize;">{{ $p->forma_pagamento }}</td>
            <td class="status">{{ $p->status }}</td>
            <td class="text-right">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
