@extends('layouts.app')

@section('content')

<div class="pt-28 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Carte Principale (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative z-10">
            
            <!-- En-tête de la carte -->
            <div class="bg-white border-b border-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-center sm:justify-start space-x-3">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Enregistrement d'entrée</h2>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 text-center sm:text-left sm:ml-11">
                    Saisissez les informations du véhicule pour générer le ticket.
                </p>
            </div>

            <div class="p-5 sm:p-8">
                <!-- Messages d'erreur -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                        <ul class="text-xs sm:text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Message de succès -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                <form id="entry-form" method="POST" action="{{ route('entres.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Champ Plaque -->
                        <div class="md:col-span-1">
                            <label for="plaque" class="block text-xs sm:text-sm font-bold text-gray-600 uppercase tracking-wider mb-2">Plaque d'immatriculation</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-bold">#</span>
                                </div>
                                <input type="text" id="plaque" name="plaque" value="{{ old('plaque') }}"
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-bold uppercase text-gray-800"
                                    placeholder="TG-1234-AB" required>
                            </div>
                            <p id="plaque-status" class="text-xs mt-2 text-red-600 font-bold hidden flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                                Ce véhicule est déjà présent !
                            </p>
                        </div>

                        <!-- Champ Type -->
                        <div class="md:col-span-1">
                            <label for="type" class="block text-xs sm:text-sm font-bold text-gray-600 uppercase tracking-wider mb-2">Type de véhicule</label>
                            <select id="type" name="type"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 font-bold text-gray-800 cursor-pointer"
                                required>
                                <option value="" disabled selected>Choisir...</option>
                                <option value="motorcycle"> Moto</option>
                                <option value="car"> Voiture</option>
                                <option value="tricycle"> Tricycle</option>
                                <option value="nyonyovi"> Nyonyovis</option>
                                <option value="minibus"> Minibus</option>
                                <option value="bus"> Bus</option>
                                <option value="truck"> Camion</option>
                            </select>
                        </div>

                        <!-- Champ Nom -->
                        <div class="md:col-span-1">
                            <label for="name" class="block text-xs sm:text-sm font-bold text-gray-600 uppercase tracking-wider mb-2">Nom du propriétaire</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 text-gray-800"
                                    placeholder="Nom complet">
                            </div>
                        </div>

                        <!-- Champ Téléphone -->
                        <div class="md:col-span-1">
                            <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-600 uppercase tracking-wider mb-2">Téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 text-gray-800"
                                    placeholder="Ex: 90000000">
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="pt-4">
                        <button type="submit" id="submit-btn"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg shadow-md transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center space-x-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="uppercase">Enregistrer l'entrée</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-400">
            <p class="text-[10px] font-bold uppercase tracking-widest">Parking Pro - Système d'entrée sécurisé</p>
        </div>
    </div>
</div>

<!-- Iframe invisible unique pour l'impression silencieuse -->
<iframe id="print_frame" name="print_frame" style="display:none;"></iframe>

<script>
    // 1. GESTION DE L'IMPRESSION AUTOMATIQUE
    @if(session('ticket_url'))
        window.onload = function() {
            var frame = document.getElementById('print_frame');
            frame.src = "{{ session('ticket_url') }}";
            
            frame.onload = function() {
                if(frame.contentWindow) {
                    frame.contentWindow.focus();
                    frame.contentWindow.print();
                }
            };
        };
    @endif

    // 2. VÉRIFICATION AJAX DE LA PLAQUE
    document.getElementById('plaque').addEventListener('blur', function () {
        const plaque = this.value;
        const type = document.getElementById('type').value;
        const statusText = document.getElementById('plaque-status');
        const btn = document.getElementById('submit-btn');
        const inputPlaque = document.getElementById('plaque');

        if (plaque && type) {
            fetch(`/check-plaque?plaque=${plaque}&type=${type}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        statusText.classList.remove('hidden');
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                        inputPlaque.classList.add('border-red-500', 'ring-red-100');
                    } else {
                        statusText.classList.add('hidden');
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        inputPlaque.classList.remove('border-red-500', 'ring-red-100');
                    }
                })
                .catch(err => console.error('Erreur AJAX:', err));
        }
    });
</script>

@endsection