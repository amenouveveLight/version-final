@extends('layouts.app')

@section('content')
<!-- Lien Font Awesome pour les icônes Odoo -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="min-h-screen bg-[#F8F9FA] pt-24 md:pt-28 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Style Odoo -->
        <div class="bg-[#714B67] rounded-t-xl p-6 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <i class="fa fa-history text-3xl"></i>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Historique des activités</h1>
                    <p class="text-purple-100 text-xs md:text-sm">Suivi temps réel des flux du parking</p>
                </div>
            </div>
        </div>

        <!-- Formulaire de recherche (Responsive Grid) -->
        <div class="bg-white p-6 shadow-sm border-x border-b border-gray-200 mb-6 rounded-b-xl">
            <form method="GET" action="{{ route('recent') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Plaque -->
                <div class="flex flex-col">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1">Plaque</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md text-gray-400">
                            <i class="fa fa-car"></i>
                        </span>
                        <input type="text" name="plaque" value="{{ request('plaque') }}" placeholder="Ex: TG-1234-AB"
                            class="flex-1 border border-gray-300 rounded-r-md px-3 py-2 focus:ring-[#714B67] focus:border-[#714B67] text-sm">
                    </div>
                </div>

                <!-- Type -->
                <div class="flex flex-col">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1">Type de véhicule</label>
                    <select name="type" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-[#714B67] focus:border-[#714B67] text-sm bg-white">
                        <option value="">Tous les types</option>
                        @foreach(['motorcycle'=>'Moto','car'=>'Voiture','tricycle'=>'Tricycle','nyonyovi'=>'Nyonyovi','minibus'=>'Minibus','bus'=>'Bus','truck'=>'Camion'] as $val => $label)
                            <option value="{{ $val }}" {{ request('type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Période -->
                <div class="flex flex-col">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1">Période</label>
                    <select name="periode" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-[#714B67] focus:border-[#714B67] text-sm bg-white">
                        <option value="">Toutes les périodes</option>
                        <option value="jour" {{ request('periode') == 'jour' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Cette semaine</option>
                        <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Ce mois</option>
                        <option value="année" {{ request('periode') == 'année' ? 'selected' : '' }}>Cette année</option>
                    </select>
                </div>

                <!-- Bouton -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#00A09D] hover:bg-[#008a87] text-white font-bold py-2 rounded-md shadow transition transform active:scale-95">
                        <i class="fa fa-search mr-2"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- VERSION PC & TABLETTE : Tableau -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date / Heure</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Plaque</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Événement</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Propriétaire</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Durée</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Statut</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($activites as $act)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-sm text-gray-600 italic"><i class="fa fa-clock-o mr-1"></i> {{ $act['date'] }}</td>
                        <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $act['plaque'] }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">
                            <span class="{{ $act['source'] === 'entree' ? 'text-blue-600' : 'text-orange-600' }} font-medium">
                                {{ $act['evenement'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $act['name'] ?? '—' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600 font-mono">{{ $act['duree'] }}</td>
                        <td class="px-4 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $act['statut'] === 'Complété' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $act['statut'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @php $route = ($act['source'] === 'entree') ? 'entres.show' : 'sorties.show'; @endphp
                            <a href="{{ route($route, $act['id']) }}" class="text-[#00A09D] hover:text-[#714B67] transition">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-10 text-gray-400 italic">Aucune activité trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- VERSION MOBILE : Cartes -->
        <div class="md:hidden space-y-4">
            @forelse ($activites as $act)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $act['date'] }}</p>
                        <h3 class="text-lg font-bold text-gray-900">{{ $act['plaque'] }}</h3>
                    </div>
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $act['statut'] === 'Complété' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $act['statut'] }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm border-t pt-3">
                    <div><p class="text-gray-400 text-xs">Propriétaire</p><p class="font-medium">{{ $act['name'] ?? '—' }}</p></div>
                    <div><p class="text-gray-400 text-xs">Durée</p><p class="font-mono">{{ $act['duree'] }}</p></div>
                </div>
                <div class="mt-4">
                    @php $route = ($act['source'] === 'entree') ? 'entres.show' : 'sorties.show'; @endphp
                    <a href="{{ route($route, $act['id']) }}" class="block w-full text-center bg-gray-100 text-gray-700 font-bold py-2 rounded-lg text-sm">
                        <i class="fa fa-info-circle mr-2"></i> Voir les détails
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-10 text-gray-400 italic bg-white rounded-xl">Aucune activité trouvée.</div>
            @endforelse
        </div>

        <!-- Pagination (Style Odoo) -->
        @if ($activites->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="inline-flex rounded-md shadow-sm">
                {{-- Lien précédent --}}
                @if ($activites->onFirstPage())
                    <span class="px-3 py-2 rounded-l-md border border-gray-300 bg-gray-50 text-gray-400 cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $activites->previousPageUrl() }}" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">‹</a>
                @endif

                {{-- Chiffres --}}
                @foreach ($activites->getUrlRange(1, $activites->lastPage()) as $page => $url)
                    @if ($page == $activites->currentPage())
                        <span class="px-4 py-2 border border-[#00A09D] bg-[#00A09D] text-white font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Lien suivant --}}
                @if ($activites->hasMorePages())
                    <a href="{{ $activites->nextPageUrl() }}" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">›</a>
                @else
                    <span class="px-3 py-2 rounded-r-md border border-gray-300 bg-gray-50 text-gray-400 cursor-not-allowed">›</span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection