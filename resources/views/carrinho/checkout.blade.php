@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-gray-800">Checkout</h1>
            <a href="{{ route('carrinho.index') }}" class="text-sm text-gray-600">← Voltar ao carrinho</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <form action="{{ route('carrinho.checkout.place') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome completo</label>
                        <input type="text" name="nome_completo" value="{{ old('nome_completo', optional($user)->name) }}" class="mt-1 block w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', optional($user)->email) }}" class="mt-1 block w-full border rounded p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Morada</label>
                        <input type="text" name="morada" value="{{ old('morada') }}" class="mt-1 block w-full border rounded p-2">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cidade</label>
                            <input type="text" name="cidade" value="{{ old('cidade') }}" class="mt-1 block w-full border rounded p-2">
                        </div>

                        <style>
                            .payment-row.selected { border-color: #6366F1; background-color: #EEF2FF; box-shadow: 0 1px 2px rgba(99,102,241,0.08); }
                            .payment-row .check-badge { display: none; }
                            .payment-row.selected .check-badge { display: flex; }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', function(){
                                const rows = document.querySelectorAll('#payment-list .payment-row');
                                const extras = document.querySelectorAll('.payment-inline');

                                function selectValue(val){
                                    rows.forEach(r=>{
                                        const v = r.dataset.value;
                                        const input = r.querySelector('input[type=radio]');
                                        if(v === val){
                                            r.classList.add('selected');
                                            if(input) input.checked = true;
                                        } else {
                                            r.classList.remove('selected');
                                            if(input) input.checked = false;
                                        }
                                    });

                                    extras.forEach(e=>{
                                            e.style.display = (e.dataset.for === val) ? '' : 'none';
                                        });

                                        // no special generation for multibanco now; it uses card fields per request
                                }

                                rows.forEach(r=>{
                                    r.addEventListener('click', ()=> selectValue(r.dataset.value));
                                    const input = r.querySelector('input[type=radio]');
                                    if(input){
                                        input.addEventListener('change', ()=> selectValue(input.value));
                                    }
                                });

                                // initialize from any checked radio or default to first
                                const checked = document.querySelector('#payment-list input[type=radio]:checked');
                                const initial = checked ? checked.value : (rows[0] ? rows[0].dataset.value : null);
                                if(initial) selectValue(initial);
                            });
                        </script>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código postal</label>
                            <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}" class="mt-1 block w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">País</label>
                        <input type="text" name="pais" value="{{ old('pais', 'Portugal') }}" class="mt-1 block w-full border rounded p-2">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de pagamento</label>

                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="text-lg font-semibold mb-3">Select a payment method</div>

                            <div id="payment-list" class="space-y-3">
                                <!-- Multibanco -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white" data-value="multibanco">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/multibanco.svg') }}" alt="Multibanco" class="w-10 h-6" />
                                        <div class="font-medium">Multibanco</div>
                                    </div>
                                    <input type="radio" name="payment_method" value="multibanco" class="form-radio h-4 w-4 text-indigo-600" {{ old('payment_method') == 'multibanco' ? 'checked' : '' }}>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50" data-for="multibanco" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Número do cartão</label>
                                    <input type="text" name="multibanco_card_number" placeholder="**** **** **** 4242" class="mt-1 block w-full border rounded p-2 mb-2">
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" name="multibanco_card_expiry" placeholder="MM/AA" class="mt-1 block w-full border rounded p-2">
                                        <input type="text" name="multibanco_card_cvc" placeholder="CVC" class="mt-1 block w-full border rounded p-2">
                                    </div>
                                </div>

                                <!-- MB WAY -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white" data-value="mbway">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/mbway.svg') }}" alt="MB WAY" class="w-10 h-6" />
                                        <div class="font-medium">MB WAY</div>
                                    </div>
                                    <input type="radio" name="payment_method" value="mbway" class="form-radio h-4 w-4 text-indigo-600" {{ old('payment_method') == 'mbway' ? 'checked' : '' }}>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50" data-for="mbway" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Telemóvel (MB WAY)</label>
                                    <input type="text" name="mbway_phone" placeholder="912345678" class="mt-1 block w-full border rounded p-2">
                                    <div class="text-xs text-gray-500 mt-2">Iremos enviar uma notificação simulada para este número.</div>
                                </div>

                                <!-- Paysafecard -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white" data-value="paysafecard">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/paysafecard.svg') }}" alt="Paysafecard" class="w-10 h-6" />
                                        <div class="font-medium">Paysafecard</div>
                                    </div>
                                    <input type="radio" name="payment_method" value="paysafecard" class="form-radio h-4 w-4 text-indigo-600" {{ old('payment_method') == 'paysafecard' ? 'checked' : '' }}>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50" data-for="paysafecard" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Email (Paysafecard)</label>
                                    <input type="email" name="paysafecard_email" placeholder="you@example.com" class="mt-1 block w-full border rounded p-2">
                                </div>

                                <!-- PayPal -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white" data-value="paypal">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/paypal.svg') }}" alt="PayPal" class="w-10 h-6" />
                                        <div class="font-medium">PayPal</div>
                                    </div>
                                    <input type="radio" name="payment_method" value="paypal" class="form-radio h-4 w-4 text-indigo-600" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50" data-for="paypal" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Conta PayPal (email)</label>
                                    <input type="email" name="paypal_email" placeholder="you@example.com" class="mt-1 block w-full border rounded p-2">
                                </div>
                                </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button id="submit-btn" type="submit" class="bg-red-700 text-white px-4 py-2 rounded">Confirmar e Pagar</button>
                    </div>
                </form>
            </div>

            <div class="md:col-span-1">
                <div class="border rounded p-4">
                    <h3 class="text-sm font-semibold mb-3">Resumo do pedido</h3>
                    @if(empty($carrinho))
                        <div class="text-sm text-gray-500">Carrinho vazio</div>
                    @else
                        <table class="w-full text-sm">
                            <tbody>
                            @foreach($carrinho as $id => $item)
                                <tr>
                                    <td>{{ $item['nome'] }} <div class="text-xs text-gray-500">x{{ $item['quantidade'] }}</div></td>
                                    <td class="text-right">€{{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="border-t mt-3 pt-3 text-right font-semibold">Total: €{{ number_format($total, 2, ',', '.') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const radios = document.querySelectorAll('input[name="payment_method"]');
        const submitBtn = document.getElementById('submit-btn');
        function update(){
            const sel = document.querySelector('input[name="payment_method"]:checked');
            if (!submitBtn) return;
            if (sel && sel.value === 'cartao') submitBtn.textContent = 'Confirmar e Pagar';
            else if (sel && sel.value === 'mbway') submitBtn.textContent = 'Pagar com MB WAY';
            else submitBtn.textContent = 'Gerar referência Multibanco';
        }
        radios.forEach(r=> r.addEventListener('change', update));
        update();
    })();
</script>
@endpush

@endsection

