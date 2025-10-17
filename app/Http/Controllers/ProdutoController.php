<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Produto;

class ProdutoController extends Controller
{
    // Listar todos os produtos
    public function index()
    {
        // If the DB or table doesn't exist (e.g. local dev without migrations),
        // return an empty collection instead of crashing the app.
        try {
            $produtos = Produto::all();
        } catch (QueryException $e) {
            $produtos = collect();
        }

        return view('produtos.index', compact('produtos'));
    }

    // Página de detalhe do produto (opcional)
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }
}
