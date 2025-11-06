<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Str;
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
        $data = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email',
            'morada' => 'required|string|max:1000',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'pais' => 'required|string|max:255',
            'payment_method' => 'required|in:cartao,mbway,multibanco',
        ]);

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
            $paymentResult['masked'] = $cardNumber ? '**** **** **** ' . substr(preg_replace('/\D/', '', $cardNumber), -4) : '****';
        } elseif ($paymentMethod === 'mbway') {
            $paymentResult['mbway_phone'] = $request->input('mbway_phone');
            $paymentResult['mbway_tx'] = 'MB' . strtoupper(Str::random(8));
        } else { // multibanco
            $paymentResult['entidade'] = '12345';
            $paymentResult['referencia'] = rand(100000000, 999999999);
            $paymentResult['valid_until'] = now()->addDays(3)->toDateString();
        }

        // Persistir encomenda e itens numa transacção
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

        // Limpar carrinho
        $request->session()->forget('carrinho');

        // Passar dados para a view de confirmação
        return view('carrinho.confirmation', [
            'orderId' => $orderId,
            'total' => $total,
            'items' => $carrinho,
            'billing' => $data,
            'payment' => $paymentResult,
            'savedOrder' => $savedOrder ?? null,
        ]);
    }
}
