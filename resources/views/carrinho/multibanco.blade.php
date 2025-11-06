@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <style>
        :root{--brand:#065f46; --accent:#06b6d4;}
        @media print { .no-print{ display:none !important; } }
        .mb-wrapper{ background:linear-gradient(180deg,#ffffff,#f8fafc); border-radius:12px; padding:20px; border:1px solid #e6eef0; }
        .mb-hero{ display:flex; gap:16px; align-items:center; }
        .mb-hero img{ width:56px; height:56px; object-fit:contain; border-radius:8px; }
        .mb-code{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, monospace; font-size:1.4rem; letter-spacing:1px; }
    .mb-panel{ background:#ffffff; border:1px solid #e6eef0; padding:18px; border-radius:10px; }
    /* button system */
    .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 12px; border-radius:10px; font-weight:600; cursor:pointer; transition:all .12s ease-in-out; text-decoration:none; }
    .btn svg{ width:18px; height:18px; display:inline-block; vertical-align:middle; }
    .btn-primary{ background:var(--brand); color:white; border:1px solid rgba(0,0,0,0.04); }
    .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 6px 18px rgba(6,95,70,0.08); }
    .btn-primary:focus{ outline:3px solid rgba(6,95,70,0.12); }
    .btn-ghost{ background:transparent; border:1px solid #d1d5db; color:#111827; }
    .btn-ghost:hover{ background:#f8fafc; transform:translateY(-1px); }
    .btn-ghost:focus{ outline:3px solid rgba(17,24,39,0.06); }
    /* responsive full-width on small screens */
    @media (max-width:767px){ .btn{ width:100%; } }
        .countdown{ font-weight:700; color:var(--brand); }
        .qr-box{ background:#fff; border:1px dashed #e6eef0; padding:10px; border-radius:8px; }
        .hint{ color:#374151; }
        .toast{ position:fixed; right:18px; top:18px; background:var(--brand); color:#fff; padding:10px 14px; border-radius:8px; display:none; z-index:9999; }
    </style>

    <div class="mb-wrapper">
        <div class="mb-hero mb-4">
            <img src="{{ asset('images/payments/multibanco.png') }}" alt="Multibanco logo">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pagamento Multibanco</h1>
                <p class="text-sm text-gray-600">Completa o pagamento no Multibanco (ATM) ou pelo teu homebanking usando a entidade e referência abaixo.</p>
            </div>
            <div style="margin-left:auto;text-align:right">
                <div class="text-sm text-gray-500">Validade</div>
                <div class="countdown">{{ $payment['valid_until'] ?? '—' }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-2 mb-panel">
                <div class="mb-2 text-sm text-gray-500">Entidade</div>
                <div class="mb-code text-gray-800">{{ $payment['entidade'] ?? '—' }}</div>

                <div class="mt-4 mb-2 text-sm text-gray-500">Referência</div>
                <div class="mb-code text-indigo-600">{{ $payment['referencia'] ?? '—' }}</div>

                <div class="mt-4 text-sm hint">Montante: <strong>€{{ number_format($order->total ?? 0, 2, ',', '.') }}</strong></div>

                <div class="mt-4 text-sm bg-gray-50 p-3 rounded">
                    <strong>Nota:</strong> guarda o comprovativo até receberes a confirmação de pagamento. Em caso de dúvidas, contacta-nos.
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <div class="mb-panel text-center">
                    <div class="qr-box mb-3">
                        @php
                            $qrData = ($payment['entidade'] ?? '') . ' ' . ($payment['referencia'] ?? '') . ' ' . ($order->total ?? '');
                            $qrUrl = $qrData ? 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData) : null;
                        @endphp
                        @if($qrUrl)
                            <img src="{{ $qrUrl }}" alt="QR code" style="width:140px;height:140px;margin:auto;display:block" />
                        @else
                            <div class="text-sm text-gray-500">QR não disponível</div>
                        @endif
                    </div>

                    <button id="copy-ref" class="btn btn-primary w-full no-print">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 12H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Copiar Entidade & Referência</span>
                    </button>
                    <button id="print-btn" class="btn btn-ghost w-full mt-2 no-print">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6 9V3h12v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><rect x="6" y="13" width="12" height="8" rx="2" stroke="currentColor" stroke-width="1.6"/></svg>
                        <span>Imprimir / Guardar PDF</span>
                    </button>
                    <a href="mailto:?subject=Instruções%20de%20pagamento&body=Entidade:%20{{ $payment['entidade'] ?? '' }}%0AReferência:%20{{ $payment['referencia'] ?? '' }}%0AValidade:%20{{ $payment['valid_until'] ?? '' }}" class="btn btn-ghost w-full mt-2 no-print">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 8.5l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 19H3V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v13z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Enviar por email</span>
                    </a>
                    <a href="{{ route('produtos.index') }}" class="btn btn-ghost w-full mt-2 no-print">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Voltar à loja</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white p-4 rounded border">
            <h3 class="font-semibold mb-2">Como pagar</h3>
            <ol class="list-decimal pl-5 space-y-2 text-sm text-gray-700">
                <li>No ATM: Escolhe Pagamentos → Pagamento Serviços/Compras → Introduz a Entidade e a Referência.</li>
                <li>No homebanking: procura Pagamentos por Referência e completa os dados da mesma forma.</li>
                <li>Confirma o montante e guarda o comprovativo.</li>
            </ol>
        </div>
    </div>

    <div id="toast" class="toast" role="status" aria-live="polite"></div>
</div>

@push('scripts')
<script>
    (function(){
        const entidade = @json($payment['entidade'] ?? '');
        const referencia = @json($payment['referencia'] ?? '');
        const total = @json($order->total ?? 0);
        const text = entidade && referencia ? `Entidade: ${entidade}\nReferência: ${referencia}\nMontante: €${Number(total).toFixed(2)}` : '';

        const copyBtn = document.getElementById('copy-ref');
        const printBtn = document.getElementById('print-btn');
        const toast = document.getElementById('toast');

        function showToast(msg){
            if(!toast) return;
            toast.textContent = msg;
            toast.style.display = 'block';
            setTimeout(()=>{ toast.style.display = 'none'; }, 2200);
        }

        copyBtn?.addEventListener('click', function(){
            if(!text){ showToast('Dados não disponíveis para copiar.'); return; }
            if(navigator.clipboard && navigator.clipboard.writeText){
                navigator.clipboard.writeText(text).then(()=> showToast('Entidade e referência copiadas.') ).catch(()=> window.prompt('Copia manualmente:', text) );
            } else { window.prompt('Copia manualmente:', text); }
        });

        printBtn?.addEventListener('click', function(){ window.print(); });
    })();
</script>
@endpush

@endsection
