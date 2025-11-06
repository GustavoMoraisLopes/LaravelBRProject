@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <style>
        /* Small visual polish for the checkout page */
        .checkout-hero{
            background: linear-gradient(90deg, rgba(99,102,241,0.08), rgba(99,102,241,0.02));
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 18px;
            display:flex;
            align-items:center;
            gap:12px;
        }
        .checkout-hero h2{ margin:0; font-weight:700; color:#1f2937; }
        .payment-row img{ width:56px; height:36px; object-fit:contain; }
        @media(min-width:768px){
            .payment-logos-horizontal{ display:flex; gap:8px; align-items:center; }
            .payment-row{ padding:12px 16px; }
        }
        .payment-row.selected{ border-color:#4f46e5; background-color:#f3f0ff; box-shadow:0 6px 18px rgba(79,70,229,0.06); }
        .check-badge{ display:none; }
        .payment-row.selected .check-badge{ display:flex; }
    </style>

    <div class="checkout-hero">
        <div style="flex:1">
            <h2>Finalizar Compra</h2>
            <div class="text-sm text-gray-600">Confirma os teus dados e escolhe o método de pagamento. As referências Multibanco expiram em 72 horas.</div>
        </div>
        <div class="payment-logos-horizontal">
            <img src="{{ asset('images/payments/cartaodecredito.png') }}" alt="Cartão" style="height:28px" />
            <img src="{{ asset('images/payments/mbway.png') }}" alt="MB WAY" style="height:28px" />
            <img src="{{ asset('images/payments/multibanco.png') }}" alt="Multibanco" style="height:28px" />
            <img src="{{ asset('images/payments/paypal.png') }}" alt="PayPal" style="height:28px" />
            <img src="{{ asset('images/payments/paysafecard.png') }}" alt="Paysafecard" style="height:28px" />
        </div>
    </div>
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 dark:text-gray-100 rounded shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-gray-800">Checkout</h1>
            <a href="{{ route('carrinho.index') }}" class="text-sm text-gray-600">← Voltar ao carrinho</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <form action="{{ route('carrinho.checkout.place') }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div id="form-errors" class="bg-red-50 border border-red-200 text-red-800 p-3 rounded mb-4 dark:bg-red-900 dark:text-red-200 dark:border-red-700">
                            <div class="font-semibold">Por favor corrija os seguintes erros:</div>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome completo</label>
                        <input type="text" name="nome_completo" value="{{ old('nome_completo', optional($user)->name) }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('nome_completo') ? 'border-red-500' : '' }}" required>
                        @error('nome_completo')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" name="email" value="{{ old('email', optional($user)->email) }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('email') ? 'border-red-500' : '' }}" required>
                        @error('email')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Morada</label>
                        <input type="text" name="morada" value="{{ old('morada') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('morada') ? 'border-red-500' : '' }}">
                        @error('morada')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cidade</label>
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
                                const hidden = document.getElementById('payment_method_input');

                                function selectValue(val){
                                    rows.forEach(r=>{
                                        const v = r.dataset.value;
                                        const input = r.querySelector('input[type=radio]');
                                        if(v === val){
                                            r.classList.add('selected');
                                            r.setAttribute('aria-pressed', 'true');
                                            if(input) input.checked = true;
                                        } else {
                                            r.classList.remove('selected');
                                            r.setAttribute('aria-pressed', 'false');
                                            if(input) input.checked = false;
                                        }
                                    });

                                    extras.forEach(e=>{
                                            e.style.display = (e.dataset.for === val) ? '' : 'none';
                                        });

                                        // update the hidden input so the server receives the selected method
                                        if(hidden) {
                                            hidden.value = val;
                                            // trigger change so other scripts (submit button text) can react
                                            hidden.dispatchEvent(new Event('change'));
                                        }

                                        // no special generation for multibanco now; it uses card fields per request
                                }

                                rows.forEach(r=>{
                                    // make rows keyboard-focusable for accessibility
                                    r.setAttribute('tabindex', '0');
                                    r.setAttribute('role', 'button');
                                    r.setAttribute('aria-pressed', 'false');

                                    r.addEventListener('click', ()=> selectValue(r.dataset.value));
                                    r.addEventListener('keydown', (e)=>{
                                        if(e.key === 'Enter' || e.key === ' '){
                                            e.preventDefault();
                                            selectValue(r.dataset.value);
                                        }
                                    });
                                });

                                // initialize from hidden input or default to first
                                const hiddenVal = hidden ? hidden.value : null;
                                const initial = hiddenVal ? hiddenVal : (rows[0] ? rows[0].dataset.value : null);
                                if(initial) selectValue(initial);
                            });
                        </script>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Código postal</label>
                            <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('codigo_postal') ? 'border-red-500' : '' }}">
                            @error('codigo_postal')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">País</label>
                        <input type="text" name="pais" value="{{ old('pais', 'Portugal') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('pais') ? 'border-red-500' : '' }}">
                        @error('pais')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de pagamento</label>

                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                            <div class="text-lg font-semibold mb-3">Escolha o método de pagamento</div>

                            <input type="hidden" name="payment_method" id="payment_method_input" value="{{ old('payment_method', 'cartao') }}">
                            <div id="payment-list" class="space-y-3">
                                <!-- Cartão de débito/crédito -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white dark:bg-gray-700" data-value="cartao">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/cartaodecredito.png') }}" alt="Cartão" class="w-10 h-6" />
                                        <div class="font-medium">Cartão de débito ou crédito</div>
                                    </div>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-700" data-for="cartao" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Número do cartão</label>
                                    <input type="text" name="card_number" placeholder="**** **** **** 4242" value="{{ old('card_number') }}" class="mt-1 block w-full border rounded p-2 mb-2 {{ $errors->has('card_number') ? 'border-red-500' : '' }}">
                                    @error('card_number')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" name="card_expiry" placeholder="MM/AA" value="{{ old('card_expiry') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('card_expiry') ? 'border-red-500' : '' }}">
                                        <input type="text" name="card_cvc" placeholder="CVC" value="{{ old('card_cvc') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('card_cvc') ? 'border-red-500' : '' }}">
                                    </div>
                                    @error('card_expiry')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                    @error('card_cvc')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Multibanco (referência) -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white dark:bg-gray-700" data-value="multibanco">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/multibanco.png') }}" alt="Multibanco" class="w-10 h-6" />
                                        <div class="font-medium">Multibanco</div>
                                    </div>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-700" data-for="multibanco" style="display:none">
                                    <div class="text-sm text-gray-700">Ao seleccionar Multibanco, ao finalizar a compra será gerada uma referência (entidade + referência) que poderás pagar num ATM ou homebanking. Não são necessários dados de cartão.</div>
                                </div>

                                <!-- MB WAY -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white dark:bg-gray-700" data-value="mbway">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/mbway.png') }}" alt="MB WAY" class="w-10 h-6" />
                                        <div class="font-medium">MB WAY</div>
                                    </div>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-700" data-for="mbway" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Telemóvel (MB WAY)</label>
                                    <input type="text" name="mbway_phone" placeholder="912345678" value="{{ old('mbway_phone') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('mbway_phone') ? 'border-red-500' : '' }}">
                                    @error('mbway_phone')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="text-xs text-gray-500 mt-2">Iremos enviar uma notificação simulada para este número.</div>
                                </div>

                                <!-- Paysafecard -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white dark:bg-gray-700" data-value="paysafecard">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/paysafecard.png') }}" alt="Paysafecard" class="w-10 h-6" />
                                        <div class="font-medium">Paysafecard</div>
                                    </div>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-700" data-for="paysafecard" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Email (Paysafecard)</label>
                                    <input type="email" name="paysafecard_email" placeholder="you@example.com" value="{{ old('paysafecard_email') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('paysafecard_email') ? 'border-red-500' : '' }}">
                                    @error('paysafecard_email')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- PayPal -->
                                <label class="payment-row relative flex items-center justify-between gap-4 p-3 border rounded cursor-pointer bg-white dark:bg-gray-700" data-value="paypal">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/payments/paypal.png') }}" alt="PayPal" class="w-10 h-6" />
                                        <div class="font-medium">PayPal</div>
                                    </div>
                                    <span class="check-badge hidden w-7 h-7 rounded-full flex items-center justify-center bg-indigo-600 text-white">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>

                                <div class="payment-inline mt-2 p-3 border rounded bg-gray-50 dark:bg-gray-800 dark:border-gray-700" data-for="paypal" style="display:none">
                                    <label class="block text-sm font-medium text-gray-700">Conta PayPal (email)</label>
                                    <input type="email" name="paypal_email" placeholder="you@example.com" value="{{ old('paypal_email') }}" class="mt-1 block w-full border rounded p-2 {{ $errors->has('paypal_email') ? 'border-red-500' : '' }}">
                                    @error('paypal_email')
                                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                    @enderror
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
                <div class="border rounded p-4 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
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
        const hidden = document.getElementById('payment_method_input');
        const submitBtn = document.getElementById('submit-btn');
        function update(){
            if (!submitBtn || !hidden) return;
            const sel = hidden.value;
            if (sel === 'cartao') submitBtn.textContent = 'Confirmar e Pagar';
            else if (sel === 'multibanco') submitBtn.textContent = 'Finalizar compra';
            else if (sel === 'mbway') submitBtn.textContent = 'Pagar com MB WAY';
            else if (sel === 'paysafecard') submitBtn.textContent = 'Pagar com Paysafecard';
            else if (sel === 'paypal') submitBtn.textContent = 'Pagar com PayPal';
            else submitBtn.textContent = 'Confirmar e Pagar';
        }

        if (hidden) hidden.addEventListener('change', update);
        // inicializar
        update();
    })();
</script>
@endpush

@endsection

