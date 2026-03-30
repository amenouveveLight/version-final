@extends('layouts.app')

@section('content')
<div class="pt-24 md:pt-32 w-full bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        <!-- Bouton Retour -->
        <div class="mb-6">
            <a href="{{ route('recent') }}" class="inline-flex items-center text-sm font-bold text-green-600 hover:text-green-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                RETOUR À L'HISTORIQUE
            </a>
        </div>

        <!-- Carte Principale (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative z-10">
            
            <!-- En-tête -->
            <div class="bg-white border-b border-gray-100 p-5 sm:p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Détails de l'entrée</h2>
                </div>
            </div>

            <!-- Contenu des détails -->
            <div class="p-5 sm:p-8">
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Référence ID</span>
                        <span class="text-sm font-mono font-bold text-gray-800">#{{ $entree->id }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Véhicule (Plaque)</span>
                        <span class="text-sm font-extrabold text-green-700 bg-green-50 px-2 py-1 rounded border border-green-100 uppercase">
                            {{ $entree->plaque }}
                        </span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Type d'engin</span>
                        <span class="text-sm font-semibold text-gray-700">{{ ucfirst($entree->type) }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Propriétaire</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $entree->name ?? 'Non renseigné' }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $entree->phone ?? 'Non renseigné' }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Arrivée le</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $entree->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row gap-3">
                    {{-- Bouton Éditer --}}
                    @if (!$hasSortie)
                        <a href="{{ route('entres.edit', $entree->id) }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition-all transform hover:-translate-y-1 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>MODIFIER</span>
                        </a>
                    @else
                        <button class="flex-1 bg-gray-200 text-gray-400 font-bold py-3 rounded-lg cursor-not-allowed flex items-center justify-center space-x-2" disabled title="Sortie déjà effectuée">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>MODIFIER (VERROUILLÉ)</span>
                        </button>
                    @endif

                    {{-- Bouton Supprimer --}}
                    @if (!$hasSortie)
                        <form action="{{ route('entres.destroy', $entree->id) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette entrée ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-600 font-bold py-3 rounded-lg transition-all flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>SUPPRIMER</span>
                            </button>
                        </form>
                    @else
                        <button class="flex-1 border-2 border-gray-200 text-gray-300 font-bold py-3 rounded-lg cursor-not-allowed flex items-center justify-center" disabled>
                            SUPPRIMER (VERROUILLÉ)
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Consultation sécurisée - Parking Pro</p>
        </div>
    </div>
</div>
@endsection