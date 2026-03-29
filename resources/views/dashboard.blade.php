@extends('layouts.app')

@section('content')

<div class="pt-16 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="mt-2 md:mt-5 w-full">
        
        <!-- Dashboard Overview Section -->
        <div id="dashboard" class="w-full max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-2 sm:py-12">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 md:p-8 sm:-mt-16 relative z-10 w-full border border-gray-100">
                
                <!-- En-tête tableau de bord -->
                <div class="flex flex-row justify-between items-center mb-6 w-full">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Tableau de bord</h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500 hidden sm:inline">Dernière mise à jour:</span>
                        <form method="GET" action="{{ route('dashboard') }}">
                            <button type="submit" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Rafraîchir les données">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats Cards (2 colonnes mobile, 4 colonnes PC) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-8 w-full">
                    <!-- Card 1: Record Journalier -->
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Record Jour</h3>
                            <div class="hidden sm:flex h-8 w-8 bg-blue-50 rounded-full items-center justify-center text-blue-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H4m0 0a4 4 0 004-4V5m5 14h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6m0 0V5m0 6h4" /></svg>
                            </div>
                        </div>
                        @if($topDailyEntry)
                            <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $topDailyEntry->total }}</p>
                            <p class="text-[9px] sm:text-xs text-gray-500 mt-1">le {{ \Carbon\Carbon::parse($topDailyEntry->date)->format('d/m/Y') }}</p>
                        @else
                            <p class="text-lg sm:text-3xl font-bold text-gray-400">–</p>
                            <p class="text-[9px] sm:text-xs text-gray-500 mt-1">Aucune donnée</p>
                        @endif
                    </div>

                    <!-- Card 2: Places Disponibles -->
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Places Dispo.</h3>
                            <div class="hidden sm:flex h-8 w-8 bg-green-50 rounded-full items-center justify-center text-green-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                        </div>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
                        <p class="text-[9px] sm:text-xs mt-1">
                            <span class="{{ ($evolution_1h[0] === '+') ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $evolution_1h }}</span>
                            <span class="text-gray-500"> (1h)</span>
                        </p>
                    </div>

                    <!-- Card 3: Places Occupées -->
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Occupées</h3>
                            <div class="hidden sm:flex h-8 w-8 bg-red-50 rounded-full items-center justify-center text-red-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
                        <p class="text-[9px] sm:text-xs mt-1">
                            <span class="{{ ($evolution_occupees_1h < 0) ? 'text-red-600' : 'text-green-600' }} font-bold">{{ $evolution_occupees_1h >= 0 ? '+' : '' }}{{ $evolution_occupees_1h }}</span>
                            <span class="text-gray-500"> (1h)</span>
                        </p>
                    </div>

                    <!-- Card 4: Taux d'occupation -->
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Taux Occ.</h3>
                            <div class="hidden sm:flex h-8 w-8 bg-yellow-50 rounded-full items-center justify-center text-yellow-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z" /></svg>
                            </div>
                        </div>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>
                        <p class="text-[9px] sm:text-xs mt-1 text-gray-500 font-bold uppercase">Capacité totale</p>
                    </div>
                </div>

                <!-- Section Statistiques -->
                <div class="w-full">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques détaillées par engin</h3> 

                    <!-- Onglets Navigation -->
                    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
                        <ul class="flex flex-nowrap sm:space-x-8 -mb-px text-center min-w-max">
                            <li class="flex-1">
                                <a href="#tab-daily" class="tab-link block py-4 px-4 border-b-2 border-green-600 text-green-600 font-bold text-xs sm:text-sm whitespace-nowrap">JOURNALIER</a>
                            </li>
                            <li class="flex-1">
                                <a href="#tab-weekly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm whitespace-nowrap uppercase">Hebdomadaire</a>
                            </li>
                            <li class="flex-1">
                                <a href="#tab-monthly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm whitespace-nowrap uppercase">Mensuel</a>
                            </li>
                            <li class="flex-1">
                                <a href="#tab-yearly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm whitespace-nowrap uppercase">Annuel</a>
                            </li>
                        </ul>
                    </div>

                    <!-- ============================================== -->
                    <!-- CONTENU DES ONGLETS (LOGIQUE RÉPÉTÉE DANS LE CODE) -->
                    <!-- ============================================== -->

                    @php
                        // Définition des périodes pour boucler la structure
                        $periods = [
                            ['id' => 'tab-daily', 'period' => 'jour', 'title' => 'Stats du Jour', 'input' => 'date', 'val' => request('date', date('Y-m-d')), 'data' => $dailyTableData, 'totalIn' => $dailyTotalEntrees, 'totalOut' => $dailyTotalSorties, 'totalRev' => $dailyRevenusTotaux, 'pie' => $dailyPieSegments, 'revs' => $dailyRevenusSegments, 'max' => $dailyRevenuMax, 'route' => 'export.jour'],
                            ['id' => 'tab-weekly', 'period' => 'semaine', 'title' => 'Stats Hebdo', 'input' => 'week', 'val' => request('date', date('Y-\WW')), 'data' => $weeklyTableData, 'totalIn' => $weeklyTotalEntrees, 'totalOut' => $weeklyTotalSorties, 'totalRev' => $weeklyRevenusTotaux, 'pie' => $weeklyPieSegments, 'revs' => $weeklyRevenusSegments, 'max' => $weeklyRevenuMax, 'route' => 'export.semaine'],
                            ['id' => 'tab-monthly', 'period' => 'mois', 'title' => 'Stats Mensuelles', 'input' => 'month', 'val' => request('date', date('Y-m')), 'data' => $monthlyTableData, 'totalIn' => $monthlyTotalEntrees, 'totalOut' => $monthlyTotalSorties, 'totalRev' => $monthlyRevenusTotaux, 'pie' => $monthlyPieSegments, 'revs' => $monthlyRevenusSegments, 'max' => $monthlyRevenuMax, 'route' => 'export.mois'],
                            ['id' => 'tab-yearly', 'period' => 'année', 'title' => 'Stats Annuelles', 'input' => 'number', 'val' => request('date', date('Y')), 'data' => $yearlyTableData, 'totalIn' => $yearlyTotalEntrees, 'totalOut' => $yearlyTotalSorties, 'totalRev' => $yearlyRevenusTotaux, 'pie' => $yearlyPieSegments, 'revs' => $yearlyRevenusSegments, 'max' => $yearlyRevenuMax, 'route' => 'export.annee']
                        ];
                    @endphp

                    @foreach($periods as $p)
                    <div id="{{ $p['id'] }}" class="tab-content {{ $loop->first ? '' : 'hidden' }} animate-fadeIn">
                        <!-- Filtres -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                            <h4 class="text-sm sm:text-md font-bold text-gray-700 uppercase">{{ $p['title'] }}</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                                <input type="{{ $p['input'] }}" name="date" value="{{ $p['val'] }}" 
                                    class="px-2 py-1 border border-gray-300 rounded text-xs sm:text-sm focus:ring-green-500 focus:border-green-500">
                                <input type="hidden" name="period" value="{{ $p['period'] }}">
                                <button type="submit" class="bg-primary-100 text-gray-700 px-3 py-1 rounded text-xs sm:text-sm font-medium hover:bg-gray-200 border border-gray-200">Appliquer</button>
                                <a href="{{ route($p['route'], ['date' => $p['val']]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs sm:text-sm font-medium hover:bg-green-700 transition-colors">PDF</a>
                            </form>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Engin</th>
                                        <th class="px-3 py-3 text-center text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">In</th>
                                        <th class="px-3 py-3 text-center text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Out</th>
                                        <th class="px-3 py-3 text-right text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Tarif</th>
                                        <th class="px-3 py-3 text-right text-[10px] sm:text-xs font-bold text-green-700 uppercase tracking-wider">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($p['data'] as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-3 text-xs sm:text-sm font-medium text-gray-900">{{ $stat['label'] }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-gray-600 text-center">{{ $stat['entrees'] }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-gray-600 text-center">{{ $stat['sorties'] }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-gray-600 text-right">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm font-bold text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-bold">
                                        <td class="px-3 py-3 text-xs sm:text-sm text-gray-900 uppercase">Total</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-center">{{ $p['totalIn'] }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-center">{{ $p['totalOut'] }}</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-right">–</td>
                                        <td class="px-3 py-3 text-xs sm:text-sm text-green-700 text-right truncate">{{ number_format($p['totalRev'], 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques 2 colonnes -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 w-full">
                            <!-- Pie Chart SVG -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col items-center shadow-sm">
                                <h5 class="text-xs sm:text-sm font-bold text-gray-600 mb-6 uppercase">Répartition Entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[320px]">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#f3f4f6" stroke-width="30" />
                                    @foreach ($p['pie'] as $s)
                                        <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30"
                                            stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($p['pie'] as $s)
                                        <rect x="200" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                        <text x="218" y="{{ $y + 10 }}" font-size="10" font-weight="bold" fill="#374151">{{ substr($s['label'],0,10) }} ({{ $s['percent'] }}%)</text>
                                        @php $y += 22; @endphp
                                    @endforeach
                                </svg>
                            </div>

                            <!-- Bar Chart SVG -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col shadow-sm">
                                <h5 class="text-xs sm:text-sm font-bold text-gray-600 mb-6 uppercase text-center">Revenus par type</h5>
                                <div class="relative h-48 sm:h-64 flex items-end justify-around px-2 border-b border-gray-100 gap-1">
                                    @foreach ($p['revs'] as $bar)
                                        @php $h = $p['max'] > 0 ? round(($bar['revenu'] / $p['max']) * 100) : 0; @endphp
                                        <div class="flex flex-col items-center w-full group">
                                            <div class="w-full max-w-[25px] rounded-t transition-all duration-300 hover:opacity-80 relative" 
                                                 style="height: {{ max($h, 3) }}%; background-color: {{ $bar['color'] }};">
                                            </div>
                                            <span class="text-[8px] sm:text-[10px] text-gray-500 mt-2 font-bold truncate w-full text-center uppercase">{{ substr($bar['label'], 0, 4) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);

                // Masquer tous les contenus et réinitialiser les styles
                contents.forEach(c => c.classList.add('hidden'));
                tabs.forEach(t => {
                    t.classList.remove('border-green-600', 'text-green-600', 'font-bold');
                    t.classList.add('border-transparent', 'text-gray-500');
                });

                // Activer l'onglet cliqué
                document.getElementById(targetId).classList.remove('hidden');
                this.classList.add('border-green-600', 'text-green-600', 'font-bold');
                this.classList.remove('border-transparent', 'text-gray-500');
            });
        });

        // Gestion de la persistance de l'onglet actif après rechargement
        const urlParams = new URLSearchParams(window.location.search);
        const period = urlParams.get('period');
        if (period) {
            const periodMap = { 'jour': 'tab-daily', 'semaine': 'tab-weekly', 'mois': 'tab-monthly', 'année': 'tab-yearly' };
            const activeTab = document.querySelector(`a[href="#${periodMap[period]}"]`);
            if (activeTab) activeTab.click();
        }
    });
</script>

@endsection