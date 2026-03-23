@extends('layouts.app')

@section('content')
<div class="pt-28">
    <!-- Ici ton contenu principal -->
    <main class="pt-2">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white shadow rounded-xl p-8">
                <h1 class="text-2xl text-gray-700  font-bold mb-4">Détails de l'entrée</h1>

                <div class="bg-white text-gray-700 shadow rounded p-4 mb-4">
                    <p><strong>ID :</strong> {{ $entree->id }}</p>
                    <p><strong>Plaque :</strong> {{ $entree->plaque }}</p>
                    <p><strong>Type :</strong> {{ ucfirst($entree->type) }}</p>
                    <p><strong>Nom :</strong> {{ $entree->name ?? '-' }}</p>
                    <p><strong>Téléphone :</strong> {{ $entree->phone ?? '-' }}</p>
                    <p><strong>Date d'entrée :</strong> {{ $entree->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="flex space-x-2">
                    {{-- Éditer --}}
@if (!$hasSortie)
    <a href="{{ route('entres.edit', $entree->id) }}"
       class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-yellow-600">
       Éditer
    </a>
@else
    <button class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" disabled>
        Éditer (verrouillé)
    </button>
@endif

{{-- Supprimer --}}
@if (!$hasSortie)
<form action="{{ route('entres.destroy', $entree->id) }}" method="POST"
      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
        Supprimer
    </button>
</form>
 @else ($user->role === 'admin,gerant')
<button class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" disabled>
    Supprimer (verrouillé)
</button>
@endif

                </div>
            </div>
        </div>
    </main>
</div>
@endsection
