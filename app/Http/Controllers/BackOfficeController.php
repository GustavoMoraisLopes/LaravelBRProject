<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\User;

class BackOfficeController extends Controller
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
            'imagem' => 'nullable|image|max:5120',
        ], [
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um número.',
            'preco.min' => 'O preço não pode ser negativo.',
            'imagem.image' => 'O ficheiro deve ser uma imagem.',
            'imagem.max' => 'A imagem não pode ser maior que 5MB.',
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
