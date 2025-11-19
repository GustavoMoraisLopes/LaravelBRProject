@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
    <div id="waiting-card" class="bg-white dark:bg-gray-900 p-8 rounded shadow text-center">
        <h2 class="text-xl font-semibold mb-2">Aguardando pagamento</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Estamos a processar o seu pagamento. Isto é uma simulação — a página irá atualizar automaticamente quando o pagamento for confirmado.</p>

        <div class="flex items-center justify-center mb-6">
            <div id="status-circle" class="w-24 h-24 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 transition-colors duration-300">
                <svg id="spinner" class="animate-spin text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="48" height="48">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>

                <svg id="check" class="hidden text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="56" height="56">
                    <path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/>
                </svg>
            </div>
        </div>

        <div class="mb-4">
            <div class="text-sm text-gray-700 dark:text-gray-200">Encomenda: <span class="font-mono">{{ $order->order_number }}</span></div>
            <div class="text-sm text-gray-700 dark:text-gray-200">Método: <strong>{{ ucfirst($payment['method'] ?? '—') }}</strong></div>
        </div>

        <div id="waiting-hint" class="text-sm text-gray-500 dark:text-gray-400">Quando fizeres o pagamento, carrega no botão abaixo "Já pagou? Clique aqui".</div>
        <button id="retry-btn" class="hidden mt-3 inline-block bg-yellow-400 text-black px-4 py-2 rounded">Tentar novamente</button>
        <button id="paid-btn" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded">Já pagou? Clique aqui</button>
    </div>
</div>

@push('scripts')
<script>
(function(){
    console.log("🟢 Script carregado corretamente!");

    const orderId = @json($order->id);
    const target = `{{ route('carrinho.confirmation', ['order' => '__ORDER__']) }}`.replace('__ORDER__', orderId);
    const confirmUrl = `{{ route('carrinho.confirm.post', ['order' => '__ORDER__']) }}`.replace('__ORDER__', orderId);
    const csrf = '{{ csrf_token() }}';

    const spinner = () => document.getElementById('spinner');
    const check = () => document.getElementById('check');
    const circle = () => document.getElementById('status-circle');
    const hint = () => document.getElementById('waiting-hint');
    const retryBtn = () => document.getElementById('retry-btn');
    const card = () => document.getElementById('waiting-card');
    const paidBtn = () => document.getElementById('paid-btn');

    let processing = false;

    function showSuccessVisual(){
        console.log("✅ Mostrar animação de sucesso!");
        const s = spinner();
        const c = check();
        const circ = circle();
        if(s) s.classList.add('hidden');
        if(c) c.classList.remove('hidden');
        if(circ){
            circ.classList.remove('bg-gray-100', 'dark:bg-gray-800');
            circ.classList.add('bg-green-50', 'dark:bg-green-900');
        }
    }

    function doConfirm(attemptCallback){
        console.log("🔄 doConfirm() chamado, processing =", processing);
        if(processing) return;
        processing = true;
        fetch(confirmUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({})
        }).then(resp=>resp.json()).then(function(data){
            console.log("🟢 Pagamento confirmado com sucesso!", data);
            showSuccessVisual();
            setTimeout(function(){ window.location.href = data.redirect || target; }, 800);
        }).catch(function(err){
            console.error("❌ Erro ao confirmar pagamento:", err);
            processing = false;
            const r = retryBtn();
            if(hint()) hint().textContent = 'Ocorreu um erro a confirmar o pagamento. Podes clicar nesta caixa para forçar a continuação ou carregar em "Tentar novamente".';
            if(r) r.classList.remove('hidden');
            if(card()) card().classList.add('cursor-pointer');
            if(typeof attemptCallback === 'function') attemptCallback();
        });
    }

    function forceContinue(){
        if(processing) return;
        processing = true;
        console.log("⚡ Forçar continuação!");
        showSuccessVisual();
        setTimeout(function(){ window.location.href = target; }, 200);
    }

    // AUTO TIMEOUT 5s
    let autoTimer = setTimeout(function(){
        console.log("⏰ Timeout disparou! processing =", processing);
        if(!processing) doConfirm();
    }, 5000);

    // Retry button
    if(retryBtn()){
        retryBtn().addEventListener('click', function(e){
            e.stopPropagation();
            console.log("🔁 Botão 'Tentar novamente' clicado");
            retryBtn().classList.add('hidden');
            if(hint()) hint().textContent = 'A tentar novamente…';
            if(autoTimer) { clearTimeout(autoTimer); autoTimer = null; }
            doConfirm();
        });
    }

    // Paid button
    if(paidBtn()){
        paidBtn().addEventListener('click', function(e){
            e.preventDefault();
            console.log("💰 Botão 'Já pagou?' clicado");
            if(autoTimer) { clearTimeout(autoTimer); autoTimer = null; }
            showSuccessVisual();
            try {
                fetch(confirmUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                }).catch(()=>{});
            } catch(err) {
                console.error("Erro no fetch manual:", err);
            }
            setTimeout(function(){ window.location.href = target; }, 500);
        });
    }

})();
</script>
@endpush

@endsection
