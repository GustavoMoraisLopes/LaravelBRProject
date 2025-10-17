<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

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
}
