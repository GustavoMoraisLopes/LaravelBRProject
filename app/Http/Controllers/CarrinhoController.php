<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CarrinhoController extends Controller
{
    // Mostrar carrinho
    public function index(Request $request)
    {
        $carrinho = $request->session()->get('carrinho', []);
        return view('carrinho.index', compact('carrinho'));
    }

    // Adicionar produto ao carrinho
    public function adicionar(Request $request, Produto $produto)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $id = $produto->id;

        if(isset($carrinho[$id])){
            $carrinho[$id]['quantidade']++;
        } else {
            $carrinho[$id] = [
                'nome' => $produto->nome,
                'preco'=> $produto->preco,
                'quantidade'=> 1
            ];
        }

        $request->session()->put('carrinho', $carrinho);
        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    // Remover produto do carrinho
    public function remover(Request $request, $id)
    {
        $carrinho = $request->session()->get('carrinho', []);
        if(isset($carrinho[$id])){
            unset($carrinho[$id]);
            $request->session()->put('carrinho', $carrinho);
        }
        return redirect()->back();
    }

    // Mostrar a página de checkout
    public function checkout(Request $request)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $user = Auth::user();
        $total = 0;
        foreach ($carrinho as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        return view('carrinho.checkout', compact('carrinho', 'total', 'user'));
    }

    // Processar (simular) o pagamento e criar uma encomenda fictícia
    public function placeOrder(Request $request)
    {
        $carrinho = $request->session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'O carrinho está vazio.');
        }

        // Validação básica de faturação + método de pagamento
        $baseRules = [
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email',
            'morada' => 'required|string|max:1000',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'pais' => 'required|string|max:255',
            'payment_method' => 'required|in:multibanco,mbway,paysafecard,paypal,cartao',
        ];

        // regras condicionais por método
        $pm = $request->input('payment_method');

        if ($pm === 'cartao') {
            // pedir dados de cartão apenas quando escolherem 'cartao'
            $baseRules['card_number'] = 'required|string';
            $baseRules['card_expiry'] = 'required|string';
            $baseRules['card_cvc'] = 'required|string';
        } elseif ($pm === 'mbway') {
            $baseRules['mbway_phone'] = 'required|string';
        } elseif ($pm === 'paysafecard') {
            $baseRules['paysafecard_email'] = 'required|email';
        } elseif ($pm === 'paypal') {
            $baseRules['paypal_email'] = 'required|email';
        }

        // mensagens em PT-PT e nomes de atributos amigáveis
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um endereço de email válido.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'string' => 'O campo :attribute tem de ser texto.',
            'in' => 'O método de pagamento seleccionado é inválido.',
        ];

        $attributes = [
            'nome_completo' => 'nome completo',
            'email' => 'email',
            'morada' => 'morada',
            'cidade' => 'cidade',
            'codigo_postal' => 'código postal',
            'pais' => 'país',
            'multibanco_card_number' => 'número do cartão',
            'multibanco_card_expiry' => 'validade do cartão',
            'multibanco_card_cvc' => 'CVC',
            'mbway_phone' => 'telemóvel (MB WAY)',
            'paysafecard_email' => 'email (Paysafecard)',
            'paypal_email' => 'email (PayPal)',
            'payment_method' => 'método de pagamento',
        ];

        $data = Validator::make($request->all(), $baseRules, $messages, $attributes)->validate();

        // calcular total
        $total = 0;
        foreach ($carrinho as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        // Gerar um id de encomenda fictício
        $orderId = strtoupper(Str::random(10));

        // Simplified payment handling: always mark as paid and store minimal info
        $paymentMethod = $request->input('payment_method');
        $paymentResult = ['method' => $paymentMethod, 'status' => 'paid'];

        // Apenas guardar informação mínima, se fornecida
        if ($paymentMethod === 'cartao') {
            $cardNumber = $request->input('card_number', '');
            $paymentResult['processor_id'] = strtoupper(Str::random(12));
            $ccDigits = preg_replace('/\D/', '', $cardNumber);
            $paymentResult['masked'] = $ccDigits ? '**** **** **** ' . substr($ccDigits, -4) : '****';
            $paymentResult['status'] = 'paid';
        } elseif ($paymentMethod === 'mbway') {
            $paymentResult['mbway_phone'] = $request->input('mbway_phone');
            $paymentResult['mbway_tx'] = 'MB' . strtoupper(Str::random(8));
            $paymentResult['status'] = 'paid';
        } elseif ($paymentMethod === 'paysafecard') {
            $paymentResult['paysafecard_email'] = $request->input('paysafecard_email');
            $paymentResult['paysafecard_tx'] = 'PS' . strtoupper(Str::random(8));
            $paymentResult['status'] = 'paid';
        } elseif ($paymentMethod === 'paypal') {
            $paymentResult['paypal_email'] = $request->input('paypal_email');
            $paymentResult['paypal_tx'] = 'PP' . strtoupper(Str::random(8));
            $paymentResult['status'] = 'paid';
        } elseif ($paymentMethod === 'multibanco') {
            // gerar referência Multibanco — status fica pendente até pagamento físico
            $paymentResult['entidade'] = '12345';
            $paymentResult['referencia'] = rand(100000000, 999999999);
            $paymentResult['valid_until'] = now()->addDays(3)->toDateString();
            $paymentResult['status'] = 'pending';
        }

        // Persistir encomenda e itens numa transacção
        try {
            DB::transaction(function () use ($request, $orderId, $total, $data, $paymentResult, $carrinho, &$savedOrder) {
                $savedOrder = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => $orderId,
                    'total' => $total,
                    'status' => $paymentResult['status'] ?? 'pending',
                    'billing' => $data,
                    'payment' => $paymentResult,
                ]);

                foreach ($carrinho as $prodId => $item) {
                    OrderItem::create([
                        'order_id' => $savedOrder->id,
                        'produto_id' => $prodId,
                        'nome' => $item['nome'],
                        'preco' => $item['preco'],
                        'quantidade' => $item['quantidade'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            // Log the error and show a graceful confirmation page (DB not available)
            Log::error('Order save failed: ' . $e->getMessage(), ['exception' => $e]);

            // Do not clear the cart automatically if DB failed — but we still show the payment info so user can proceed.
            // Provide the confirmation view with a db_error flag so the UI can communicate clearly.
            return view('carrinho.confirmation', [
                'orderId' => $orderId,
                'total' => $total,
                'items' => $carrinho,
                'billing' => $data,
                'payment' => $paymentResult,
                'savedOrder' => null,
                'db_error' => true,
            ]);
        }

        // Limpar carrinho
        $request->session()->forget('carrinho');

        // Se for Multibanco, redireccionar para a página de instruções (entidade + referência)
        // Use a temporary signed URL so the page cannot be accessed by guessing the order ID.
        if ($paymentMethod === 'multibanco') {
            // expires in 60 minutes
            return redirect()->temporarySignedRoute('carrinho.multibanco', now()->addMinutes(60), ['order' => $savedOrder->id]);
        }

        // Passar dados para a view de confirmação (outros métodos)
        return view('carrinho.confirmation', [
            'orderId' => $orderId,
            'total' => $total,
            'items' => $carrinho,
            'billing' => $data,
            'payment' => $paymentResult,
            'savedOrder' => $savedOrder ?? null,
        ]);
    }

    // Mostrar página com instruções Multibanco (entidade + referência)
    public function multibancoInstructions(Order $order)
    {
        // Route is protected by signed middleware; we rely on route model binding to fetch the Order.
        if (!$order) {
            return redirect()->route('produtos.index')->with('error', 'Encomenda não encontrada.');
        }

        $payment = $order->payment ?? [];

        return view('carrinho.multibanco', [
            'order' => $order,
            'payment' => $payment,
        ]);
    }
}
