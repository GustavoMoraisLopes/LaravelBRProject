@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-xl p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-red-700"></i> Adicionar Produto
            </h1>
            <p class="text-gray-600 mt-2">Preenche os dados do novo produto</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="font-semibold"><i class="fa-solid fa-exclamation-circle"></i> Erros encontrados:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('backoffice.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="nome" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-tag"></i> Nome do Produto
                </label>
                <input
                    type="text"
                    name="nome"
                    id="nome"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent transition"
                    placeholder="Ex: Vinho do Porto Vintage"
                    value="{{ old('nome') }}"
                    required
                >
            </div>

            <div>
                <label for="descricao" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-align-left"></i> Descrição
                </label>
                <textarea
                    name="descricao"
                    id="descricao"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent transition"
                    placeholder="Descreve as características do produto..."
                >{{ old('descricao') }}</textarea>
            </div>

            <div>
                <label for="preco" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-euro-sign"></i> Preço (€)
                </label>
                <input
                    type="number"
                    name="preco"
                    id="preco"
                    step="0.01"
                    min="0"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-700 focus:border-transparent transition"
                    placeholder="0.00"
                    value="{{ old('preco') }}"
                    required
                >
            </div>

            <div>
                <label for="imagem" class="block text-gray-700 font-semibold mb-2">
                    <i class="fa-solid fa-image"></i> Imagem do Produto
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-red-700 transition">
                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600 mb-2">Clica para escolher uma imagem</p>
                    <input
                        type="file"
                        name="imagem"
                        id="imagem"
                        accept="image/*"
                        class="w-full"
                    >
                    <p class="text-sm text-gray-500 mt-2">JPG, PNG ou GIF (máx. 5MB)</p>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button
                    type="submit"
                    class="flex-1 bg-red-700 text-white font-semibold py-3 rounded-lg hover:bg-red-800 transition transform hover:scale-105 shadow-lg"
                >
                    <i class="fa-solid fa-check"></i> Guardar Produto
                </button>
                <a
                    href="{{ route('backoffice') }}"
                    class="flex-1 bg-gray-500 text-white font-semibold py-3 rounded-lg hover:bg-gray-600 transition text-center"
                >
                    <i class="fa-solid fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Preview da imagem (opcional) -->
    <script>
        document.getElementById('imagem').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Podes adicionar preview aqui se quiseres
                    console.log('Imagem carregada:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</div>
@endsection
