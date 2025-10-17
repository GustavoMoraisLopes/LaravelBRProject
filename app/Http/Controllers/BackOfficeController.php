<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\User;

class BackofficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                abort(403, 'Acesso negado.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $produtos = Produto::all();
        $utilizadores = User::all();
        return view('backoffice.index', compact('produtos', 'utilizadores'));
    }

    public function create()
    {
        return view('backoffice.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('imagem')?->store('produtos', 'public');

        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $path,
        ]);

        return redirect()->route('backoffice')->with('success', 'Produto adicionado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return back()->with('success', 'Produto eliminado com sucesso!');
    }
}
