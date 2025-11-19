@component('mail::message')
# Encomenda recebida — {{ $order->order_number }}

Olá {{ $order->billing['nome_completo'] ?? $order->user->name ?? 'cliente' }},

Obrigado pela tua encomenda! Abaixo tens o resumo:

@component('mail::table')
| Produto | Quantidade | Preço |
|:-------|:----------:|------:|
@foreach($items as $it)
| {{ $it['nome'] }} | {{ $it['quantidade'] }} | €{{ number_format($it['preco'] * $it['quantidade'], 2, ',', '.') }} |
@endforeach
| **Total** |  | **€{{ number_format($order->total, 2, ',', '.') }}** |
@endcomponent

Método de pagamento: **{{ ucfirst($order->payment['method'] ?? '—') }}**

Podes consultar o estado da encomenda na tua conta ou nesta ligação:

@component('mail::button', ['url' => route('carrinho.confirmation', ['order' => $order->id])])
Ver Encomenda
@endcomponent

Obrigado,

Equipa Tuguinha
@endcomponent
