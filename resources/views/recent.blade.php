@extends('layouts.app')

@section('content')

<div class="pt-16 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête de page -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Historique des activités</h1>
                <p class="text-sm text-gray-500">Consultez et filtrez tous les mouvements du parking.</p>
            </div>
            <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-100 inline-flex items-center">
                <span class="flex h-3 w-3 relative mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-xs font-bold text-gray-600 uppercase tracking-widest">Mise à jour en direct</span>
            </div>
        </div>

        <!-- Section Filtrage (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 mb-8">
            <form method="GET" action="{{ route('recent') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    
                    <!-- Plaque -->
                    <div>
                        <label for="plaque" class="block text-xs font-bold text-gray-500 uppercase mb-2">Plaque</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="plaque" id="plaque" value="{{ request('plaque') }}"
                                placeholder="Rechercher..."
                                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 text-sm">
                        </div>
                    </div>

                    <!-- Type de véhicule -->
                    <div>
                        <label for="type" class="block text-xs font-bold text-gray-500 uppercase mb-2">Type d'engin</label>
                        <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 text-sm font-semibold text-gray-700">
                            <option value="">Tous les types</option>
                            @foreach(['motorcycle' => 'Moto', 'car' => 'Voiture', 'tricycle' => 'Tricycle', 'nyonyovi' => 'Nyonyovi', 'minibus' => 'Minibus', 'bus' => 'Bus', 'truck' => 'Camion'] as $val => $label)
                                <option value="{{ $val }}" {{ request('type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Période -->
                    <div>
                        <label for="periode" class="block text-xs font-bold text-gray-500 uppercase mb-2">Période</label>
                        <select name="periode" id="periode" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 text-sm font-semibold text-gray-700">
                            <option value="">Toute période</option>
                            <option value="jour" {{ request('periode') == 'jour' ? 'selected' : '' }}>Aujourd'hui</option>
                            <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Cette semaine</option>
                            <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Ce mois</option>
                            <option value="année" {{ request('periode') == 'année' ? 'selected' : '' }}>Cette année</option>
                        </select>
                    </div>

                    <!-- Bouton Rechercher -->
                    <div>
                        <button type="submit" class="w-full bg-gray-800 hover:bg-black text-white font-bold py-2 px-4 rounded-lg transition-all flex items-center justify-center space-x-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>FILTRER</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tableau des activités (Style Dashboard) -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Date & Heure</th>
                            <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Véhicule</th>
                            <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Propriétaire</th>
                            <th class="px-4 py-4 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-4 py-4 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-4 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($activites as $act)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Date -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-xs font-bold text-gray-900">{{ $act['date'] }}</div>
                                <div class="text-[10px] text-gray-400 uppercase">{{ $act['evenement'] }}</div>
                            </td>
                            <!-- Véhicule -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-extrabold text-green-700 bg-green-50 px-2 py-1 rounded border border-green-100 uppercase">{{ $act['plaque'] }}</div>
                                    <span class="ml-2 text-[10px] text-gray-400 italic">({{ $act['type'] }})</span>
                                </div>
                            </td>
                            <!-- Nom -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-700 font-medium">{{ $act['name'] ?? 'Inconnu' }}</div>
                            </td>
                            <!-- Durée -->
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <div class="text-xs text-gray-600">{{ $act['duree'] ?? '--' }}</div>
                            </td>
                            <!-- Statut -->
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @if ($act['statut'] === 'Complété')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 uppercase shadow-sm">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"></circle></svg>
                                        Terminé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase shadow-sm">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"></circle></svg>
                                        En cours
                                    </span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-4 py-4 whitespace-nowrap text-right text-xs">
                                @if ($act['source'] === 'entree')
                                    <a href="{{ route('entres.show', $act['id']) }}" class="text-blue-600 hover:text-blue-900 font-bold flex items-center justify-end group">
                                        <span>Détails</span>
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    </a>
                                @else
                                    <a href="{{ route('sorties.show', $act['id']) }}" class="text-orange-600 hover:text-orange-900 font-bold flex items-center justify-end group">
                                        <span>Détails</span>
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                <svg class="mx-auto h-12 w-12 text-gray-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Aucune activité trouvée pour ces critères.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Stylisée -->
            @if ($activites->hasPages())
            <div class="bg-gray-50 px-4 py-4 border-t border-gray-100 flex items-center justify-center">
                <nav class="inline-flex shadow-sm rounded-md overflow-hidden border border-green-200">
                    {{-- Page Précédente --}}
                    @if ($activites->onFirstPage())
                        <span class="px-3 py-2 bg-white text-gray-300 cursor-not-allowed">‹</span>
                    @else
                        <a href="{{ $activites->previousPageUrl() }}" class="px-3 py-2 bg-white text-green-600 hover:bg-green-50">‹</a>
                    @endif

                    {{-- Numéros de page --}}
                    @foreach ($activites->getUrlRange(max(1, $activites->currentPage() - 2), min($activites->lastPage(), $activites->currentPage() + 2)) as $page => $url)
                        @if ($page == $activites->currentPage())
                            <span class="px-4 py-2 bg-green-600 text-white font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 bg-white text-green-600 hover:bg-green-50">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Page Suivante --}}
                    @if ($activites->hasMorePages())
                        <a href="{{ $activites->nextPageUrl() }}" class="px-3 py-2 bg-white text-green-600 hover:bg-green-50">›</a>
                    @else
                        <span class="px-3 py-2 bg-white text-gray-300 cursor-not-allowed">›</span>
                    @endif
                </nav>
            </div>
            @endif
        </div>

        <div class="mt-8 text-center">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">Parking Pro - Historique sécurisé</p>
        </div>
    </div>
</div>

@endsection