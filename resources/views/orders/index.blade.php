@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Histórico de encomendas</h1>

    @if($orders->isEmpty())
        <div class="bg-white p-6 rounded shadow">Não tens encomendas registadas.</div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">Encomenda <span class="font-mono">{{ $order->order_number }}</span></div>
                            <div class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }} — {{ ucfirst($order->status) }}</div>
                        </div>
                        <div class="font-bold">€{{ number_format($order->total, 2, ',', '.') }}</div>
                    </div>

                    <div class="mt-3">
                        <h4 class="font-medium">Itens</h4>
                        <ul class="divide-y">
                            @foreach($order->items as $it)
                                <li class="py-2 flex justify-between">
                                    <div>
                                        <div class="font-medium">{{ $it->nome }}</div>
                                        <div class="text-sm text-gray-600">Qtd: {{ $it->quantidade }}</div>
                                    </div>
                                    <div class="font-semibold">€{{ number_format($it->preco * $it->quantidade, 2, ',', '.') }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-3 text-sm text-gray-600">
                        @if($order->payment)
                            Método: {{ ucfirst($order->payment['method'] ?? '—') }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
