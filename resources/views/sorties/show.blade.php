@extends('layouts.app')

@section('content')
<div class="pt-28 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        <!-- Bouton Retour -->
        <div class="mb-6">
            <a href="{{ route('recent') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-red-600 transition uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à l'historique
            </a>
        </div>

        <!-- Carte Principale (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative z-10">
            
            <!-- En-tête de la carte -->
            <div class="bg-white border-b border-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-red-100 p-2 rounded-lg">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Détails de la sortie</h2>
                            <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Référence Facture #{{ $sortie->id }}</p>
                        </div>
                    </div>
                    <!-- Badge Statut Paiement -->
                    @if($sortie->paiement_ok)
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase border border-green-200">Payé</span>
                    @else
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase border border-amber-200">En attente</span>
                    @endif
                </div>
            </div>

            <!-- Contenu des informations -->
            <div class="p-6 sm:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Colonne 1 : Véhicule & Client -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Informations Véhicule</h3>
                            <div class="flex items-center space-x-3">
                                <div class="text-sm font-extrabold text-red-700 bg-red-50 px-3 py-1.5 rounded border border-red-100 uppercase tracking-wider">
                                    {{ $sortie->plaque }}
                                </div>
                                <span class="text-sm font-bold text-gray-700">({{ ucfirst($sortie->type) }})</span>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Propriétaire</h3>
                            <p class="text-sm font-bold text-gray-800">{{ $sortie->owner_name ?? 'Client Divers' }}</p>
                            <p class="text-xs text-gray-500">{{ $sortie->owner_phone ?? 'Aucun téléphone' }}</p>
                        </div>

                        <div>
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Agent Responsable</h3>
                            <p class="text-sm font-semibold text-gray-700">{{ $sortie->user->firstname ?? 'Système' }} {{ $sortie->user->lastname ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Colonne 2 : Temps & Facturation -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Horaires & Durée</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Date Sortie :</span>
                                    <span class="font-bold text-gray-800">{{ $sortie->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Mode de paiement :</span>
                                    <span class="font-bold text-gray-800 uppercase italic">
                                        @if($sortie->paiement == 'cash')  Espèces 
                                        @elseif($sortie->paiement == 'card')  Carte
                                        @else  Application @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bloc Montant -->
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Montant Total Perçu</h3>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-3xl font-extrabold text-green-700">{{ number_format($sortie->montant, 0, ',', ' ') }}</span>
                                <span class="text-sm font-bold text-green-600">FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                    
                    <!-- Bouton Modifier -->
                    {{-- Assurez-vous que la route 'sorties.edit' existe --}}
                    @can('update', $sortie) {{-- Ou une autre permission pertinente, par exemple 'update-sortie' --}}
                        <a href="{{ route('sorties.edit', $sortie->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg shadow-md transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-2.036a1 1 0 111.414 1.414L17 7.414M15 11h6v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h6M7 15l3 3L22 7" />
                            </svg>
                            <span class="text-xs uppercase tracking-widest">Modifier</span>
                        </a>
                    @endcan

                    <!-- Bouton Imprimer Reçu (Action principale) -->
                    <button onclick="window.print()" class="flex-1 bg-gray-800 hover:bg-black text-white font-bold py-4 rounded-lg shadow-md transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span class="text-xs uppercase tracking-widest">Imprimer le reçu</span>
                    </button>

                    <!-- Bouton Supprimer (Si admin ou gérant seulement) -->
                    {{-- Vérifie si l'utilisateur a la permission de supprimer --}}
                    {{-- Vous pourriez avoir une permission globale comme 'delete-sortie' ou vérifier le rôle --}}
                    @can('delete', $sortie) {{-- Ou @role('admin|gerant') si vous utilisez spatie/laravel-permission --}}
                        <form action="{{ route('sorties.destroy', $sortie->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Voulez-vous vraiment annuler cette sortie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-white border border-red-200 text-red-600 font-bold py-4 rounded-lg hover:bg-red-50 transition-all text-xs uppercase tracking-widest flex items-center justify-center space-x-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Annuler la transaction</span>
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Note footer -->
        <div class="mt-8 text-center">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">Transaction sécurisée par Parking Pro</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .pt-24, .mb-6, .mt-12, .text-center { display: none !important; }
        .shadow-lg { shadow: none !important; border: none !important; }
        .bg-gray-50 { background: white !important; }
        .max-w-3xl { max-width: 100% !important; margin: 0 !important; }
    }
</style>
@endsection