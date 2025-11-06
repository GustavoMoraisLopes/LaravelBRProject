@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded shadow text-center">
        <h1 class="text-2xl font-bold mb-2">Obrigado pela sua encomenda!</h1>
        <p class="mb-4">Encomenda <span class="font-mono">{{ $orderId }}</span> confirmada.</p>

        <div class="mb-4">
            <strong>Valor:</strong> €{{ number_format($total, 2, ',', '.') }}
        </div>

        <div class="mb-4">
            <strong>Método de pagamento:</strong>
            <div class="mt-2">
                @if(isset($payment) && $payment['method'] === 'cartao')
                    Cartão de Crédito — <span class="font-mono">{{ $payment['masked'] ?? '****' }}</span>
                    <div class="text-sm text-gray-600">Pagamento processado (id: {{ $payment['processor_id'] ?? '—' }}).</div>
                @elseif(isset($payment) && $payment['method'] === 'mbway')
                    MB WAY — número: <span class="font-mono">{{ $payment['mbway_phone'] ?? '—' }}</span>
                    <div class="text-sm text-gray-600">Transacção: {{ $payment['mbway_tx'] ?? '—' }} (estado: {{ $payment['status'] }})</div>
                @elseif(isset($payment) && $payment['method'] === 'multibanco')
                    Multibanco — Entidade: <span class="font-mono">{{ $payment['entidade'] }}</span> Referência: <span class="font-mono">{{ $payment['referencia'] }}</span>
                    <div class="text-sm text-gray-600">Validade até: {{ $payment['valid_until'] }}</div>
                @else
                    —
                @endif
            </div>
        </div>

        <div class="text-left max-w-xl mx-auto">
            <h3 class="font-semibold">Itens</h3>
            <ul class="divide-y">
                @foreach($items as $id => $item)
                    <li class="py-2 flex justify-between">
                        <div>
                            <div class="font-medium">{{ $item['nome'] }}</div>
                            <div class="text-sm text-gray-600">Quantidade: {{ $item['quantidade'] }}</div>
                        </div>
                        <div class="font-semibold">€{{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <a href="{{ route('produtos.index') }}" class="text-primary">Voltar à loja</a>
        </div>
    </div>
</div>
@endsection
