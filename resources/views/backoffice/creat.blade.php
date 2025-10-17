@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Adicionar Produto</h1>

    <form action="{{ route('backoffice.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço (€)</label>
            <input type="number" name="preco" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem</label>
            <input type="file" name="imagem" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('backoffice') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
