@extends('layouts.app')

@section('content')

<div class="pt-28 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Carte principale (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative z-10">
            
            <!-- En-tête de la carte -->
            <div class="bg-white border-b border-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-center sm:justify-start space-x-3">
                    <div class="bg-red-100 p-2 rounded-lg">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Enregistrer une Sortie</h2>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 text-center sm:text-left sm:ml-11">
                    Recherchez un véhicule par sa plaque pour valider son départ.
                </p>
            </div>

            <div class="p-5 sm:p-8">
                
                <!-- Messages Flash Stylisés -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Section Recherche -->
                <form action="{{ route('sorties.create') }}" method="GET" class="mb-8">
                    <label for="plaque" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Rechercher la plaque</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="plaque" id="plaque" 
                                   placeholder="Ex: TG-1234-AB"
                                   value="{{ old('plaque', $plaque ?? '') }}"
                                   onchange="this.form.submit()"
                                   required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500 font-bold uppercase text-gray-800">
                        </div>
                        <button type="submit" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-black transition-all">
                            VÉRIFIER
                        </button>
                    </div>
                    @error('plaque')
                        <p class="text-xs text-red-600 mt-2 font-bold">{{ $message }}</p>
                    @enderror


                </form>
                    
@if(session('success'))
    <div class="p-4 mb-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }} (Impression en cours...)
    </div>
@endif

                <hr class="mb-8 border-gray-100">

                @if(!empty($typesDisponibles))
                    <!-- Formulaire de sortie -->
                    <form method="POST" action="{{ route('sorties.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="plaque" value="{{ old('plaque', $plaque ?? '') }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type de véhicule -->
                            <div>
                                <label for="type" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Type détecté</label>
                                <select name="type" id="type" required onchange="updateMontant()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 font-bold text-gray-800">
                                    <option value="">-- Sélectionnez --</option>
                                    @foreach ($types as $val => $infos)
                                        @if(in_array($val, $typesDisponibles))
                                            <option value="{{ $val }}" {{ (old('type', $dernierType ?? '') === $val) ? 'selected' : '' }}>
                                                {{ $infos['label'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Montant -->
                            <div>
                                <label for="montant" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Montant à percevoir</label>
                                <div class="relative">
                                    <input type="text" name="montant" id="montant" value="{{ $montant ?? '—' }}" readonly
                                           class="w-full px-4 py-3 border border-gray-200 bg-gray-100 text-green-700 font-extrabold text-lg rounded-lg cursor-not-allowed">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold text-sm">FCFA</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Méthode de paiement -->
                            <div>
                                <label for="paiement" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Mode de paiement</label>
                                <select name="paiement" id="paiement" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 font-bold text-gray-800">
                                    <option value="">-- Choisir --</option>
                                    @foreach(['cash' => 'Espèces', 'card' => 'Carte', 'app' => 'Application'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('paiement') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Paiement effectué -->
                            <div class="flex items-end pb-1">
                                <label class="relative inline-flex items-center cursor-pointer p-3 border border-gray-200 rounded-lg w-full bg-gray-50 hover:bg-gray-100 transition-all">
                                    <input type="checkbox" name="paiement_ok" id="paiement_ok" class="sr-only peer" {{ old('paiement_ok') ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[14px] after:left-[14px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    <span class="ml-14 text-sm font-bold text-gray-700 uppercase">Paiement reçu</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bouton de validation -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg shadow-md transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>VALIDER LA SORTIE</span>
                            </button>
                        </div>
                    </form>

                @elseif(isset($plaque))
                    <!-- Message si aucune sortie trouvée -->
                    <div class="mt-6 p-6 bg-red-50 rounded-xl border border-red-100 flex items-center space-x-4">
                        <div class="bg-red-200 p-2 rounded-full">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-800 font-bold uppercase text-xs sm:text-sm">Véhicule non trouvé ou déjà sorti</p>
                            <p class="text-red-600 text-xs">Vérifiez la plaque ou consultez l'historique des entrées.</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Système de gestion de Parking professionnel</p>
        </div>
    </div>
</div>


<!-- IFRAME INVISIBLE POUR L'IMPRESSION -->
<iframe id="print_frame" name="print_frame" style="position:absolute; top:-9999px; left:-9999px; border:none;"></iframe>

<script>
    // GESTION DE L'IMPRESSION AUTOMATIQUE
    @if(session('ticket_url'))
        window.onload = function() {
            const frame = document.getElementById('print_frame');
            frame.src = "{{ session('ticket_url') }}";
            
            frame.onload = function() {
                setTimeout(function() {
                    frame.contentWindow.focus();
                    frame.contentWindow.print();
                }, 500);
            };
        };
    @endif
</script>

@endsection