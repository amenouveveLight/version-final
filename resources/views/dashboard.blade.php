@extends('layouts.app')

@section('content')

<div class="pt-20 md:pt-28">
    <!-- Contenu principal -->
    <div class="mt-5">
        
        <!-- Dashboard Overview Section -->
        <div id="dashboard" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 md:p-8 -mt-8 md:-mt-16 relative z-10">
                
                <!-- En-tête tableau de bord -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Tableau de bord</h2>
                    <div class="flex items-center space-x-2 w-full sm:w-auto justify-between sm:justify-end">
                        <span class="text-sm sm:text-base text-gray-500">Dernière mise à jour:</span>
                        <form method="GET" action="{{ route('dashboard') }}">
                            <button type="submit" class="p-2 rounded-full hover:bg-gray-100" title="Rafraîchir les données">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats Cards (1 colonne mobile, 2 tablettes, 4 PC) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                    
                    <!-- Card 1 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs sm:text-sm font-medium text-gray-500">Record journalier</h3>
                            <div class="h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2a4 4 0 00-4-4H4m0 0a4 4 0 004-4V5m5 14h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6m0 0V5m0 6h4" />
                                </svg>
                            </div>
                        </div>
                        @if($topDailyEntry)
                            <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ $topDailyEntry->total }}</p>
                            <div class="mt-1 flex items-center text-xs sm:text-sm">
                                <span class="text-gray-500">le {{ \Carbon\Carbon::parse($topDailyEntry->date)->format('d/m/Y') }}</span>
                            </div>
                        @else
                            <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-400">–</p>
                            <div class="mt-1 flex items-center text-xs sm:text-sm">
                                <span class="text-gray-500">Aucune donnée</span>
                            </div>
                        @endif
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs sm:text-sm font-medium text-gray-500">Places disponibles</h3>
                            <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
                        <div class="mt-1 flex items-center text-xs sm:text-sm">
                            <span class="{{ ($evolution_1h[0] === '+') ? 'text-green-600' : 'text-red-600' }}">
                                {{ $evolution_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">depuis 1h</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs sm:text-sm font-medium text-gray-500">Places occupées</h3>
                            <div class="h-8 w-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
                        <div class="mt-1 flex items-center text-xs sm:text-sm">
                            <span class="{{ ($evolution_occupees_1h < 0) ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h >= 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">depuis 1h</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs sm:text-sm font-medium text-gray-500">Taux d'occupation</h3>
                            <div class="h-8 w-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>
                        <div class="mt-1 flex items-center text-xs sm:text-sm">
                            <span class="{{ $evolution_occupees_1h < 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h > 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">depuis 1h</span>
                        </div>
                    </div>
                </div>

                <!-- Section Statistiques -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des engins</h3> 

                    <!-- Onglets (Scrollable horizontalement sur mobile) -->
                    <div class="border-b border-gray-200 mb-4 overflow-x-auto">
                        <ul class="flex whitespace-nowrap -mb-px text-sm font-medium text-green-600">
                            <li class="mr-2">
                                <a href="#tab-daily" class="inline-block p-4 border-b-2 font-semibold hover:text-green-600 hover:border-green-600">Journalier</a>
                            </li>
                            <li class="mr-2">
                                <a href="#tab-weekly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500">Hebdomadaire</a>
                            </li>
                            <li class="mr-2">
                                <a href="#tab-monthly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500">Mensuel</a>
                            </li>
                            <li>
                                <a href="#tab-yearly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500">Annuel</a>
                            </li>
                        </ul>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet "Statistiques du jour" -->
                    <!-- ============================================== -->
                    <div id="tab-daily" class="tab-content">
                        <!-- Filtres (En colonne sur mobile, en ligne sur PC) -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-4">
                            <h4 class="text-md font-medium text-gray-700">Statistiques du jour</h4>
                            
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center w-full lg:w-auto space-y-2 sm:space-y-0 sm:space-x-2">
                                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                                    class="w-full sm:w-auto px-3 py-2 sm:py-1 border border-green-300 rounded-md text-sm text-gray-900 hover:border-green-600 focus:ring-green-500 focus:border-green-500">
                                <input type="hidden" name="period" value="jour">
                                
                                <div class="flex w-full sm:w-auto space-x-2">
                                    <button type="submit" class="flex-1 sm:flex-none bg-primary-100 px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-primary-200 text-gray-700">
                                        Appliquer
                                    </button>
                                    <a href="{{ route('export.jour',['date' => request('date', date('Y-m-d'))]) }}" 
                                        class="flex-1 sm:flex-none text-center bg-green-600 text-white px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-green-700">
                                        Exporter PDF
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau (Avec overflow-x-auto pour mobile) -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Type d'engin</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Entrées</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sorties</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tarif</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 bg-white">
                                    @foreach ($dailyTableData as $stat)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $stat['label'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['entrees'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['sorties'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['tarif'], 0, ',', ' ') }} FCFA</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['revenu'], 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-semibold text-gray-900">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">Total</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $dailyTotalEntrees }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $dailyTotalSorties }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">–</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ number_format($dailyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                            <!-- Graphique Circulaire -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
                                <div class="flex justify-center items-start overflow-hidden">
                                    <svg viewBox="0 0 320 200" class="w-full max-w-sm h-auto">
                                        <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                        @foreach ($dailyPieSegments as $s)
                                        <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30"
                                            stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                        @endforeach
                                        @php $y = 20; @endphp
                                        @foreach ($dailyPieSegments as $s)
                                        <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                        <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ $s['label'] }} ({{ $s['percent'] }}%)</text>
                                        @php $y += 20; @endphp
                                        @endforeach
                                    </svg>
                                </div>
                            </div>

                            <!-- Graphique à barres -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus journaliers</h5>
                                <!-- overflow-x-auto pour éviter l'écrasement des barres -->
                                <div class="relative h-64 flex items-end justify-between px-2 sm:px-4 overflow-x-auto gap-2 pb-2">
                                    @foreach ($dailyRevenusSegments as $bar)
                                    @php
                                        $height = $dailyRevenuMax > 0 ? round(($bar['revenu'] / $dailyRevenuMax) * 100) : 0;
                                    @endphp
                                    <div class="flex flex-col items-center min-w-[30px]">
                                        <div class="w-6 rounded-t mb-1 text-white text-[10px] text-center flex items-end justify-center pb-1"
                                            style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }};">
                                            <!-- {{ number_format($bar['revenu'], 0, ',', ' ') }} -->
                                        </div>
                                        <span class="text-[10px] text-gray-700 truncate max-w-full" title="{{ $bar['label'] }}">{{ $bar['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Hebdomadaire -->
                    <!-- ============================================== -->
                    <div id="tab-weekly" class="tab-content hidden">
                        <!-- En-tête -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-4">
                            <h4 class="text-md font-medium text-gray-700">Statistiques hebdomadaires</h4>
                            
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center w-full lg:w-auto space-y-2 sm:space-y-0 sm:space-x-2">
                                <input type="week" name="date" id="weekly-week"
                                    class="w-full sm:w-auto px-3 py-2 sm:py-1 border border-gray-300 rounded-md text-sm text-gray-900 focus:ring-green-500 focus:border-green-500"
                                    value="{{ request('date', now()->format('Y') . '-W' . now()->format('W')) }}">
                                <input type="hidden" name="period" value="semaine">
                                
                                <div class="flex w-full sm:w-auto space-x-2">
                                    <button type="submit" class="flex-1 sm:flex-none bg-primary-100 text-gray-700 px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-primary-200">
                                        Appliquer
                                    </button>
                                    <a href="{{ route('export.semaine',['date' => request('date', date('Y-m-d'))]) }}"
                                        class="flex-1 sm:flex-none text-center bg-green-600 text-white px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-green-700">
                                        Exporter PDF
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <!-- ... (Même structure de tableau que daily) ... -->
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Type d'engin</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Entrées</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sorties</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tarif</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($weeklyTableData as $stat)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $stat['label'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['entrees'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['sorties'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['tarif'], 0, ',', ' ') }} FCFA</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['revenu'], 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-semibold text-gray-900">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">Total</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $weeklyTotalEntrees }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $weeklyTotalSorties }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">–</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ number_format($weeklyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Graphique Circulaire -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées</h5>
                                <div class="flex justify-center items-start overflow-hidden">
                                    <svg viewBox="0 0 320 200" class="w-full max-w-sm h-auto">
                                        <!-- ... (même structure SVG) ... -->
                                    </svg>
                                </div>
                            </div>
                            <!-- Graphique à barres -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus hebdomadaires</h5>
                                <div class="relative h-64 flex items-end justify-between px-2 sm:px-4 overflow-x-auto gap-2 pb-2">
                                    @foreach ($weeklyRevenusSegments as $bar)
                                    @php $height = $weeklyRevenuMax > 0 ? round(($bar['revenu'] / $weeklyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center min-w-[30px]">
                                        <div class="w-6 rounded-t mb-1 text-white text-[10px] text-center flex items-end justify-center pb-1"
                                            style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }}">
                                            {{ round($bar['revenu'] / 1000) }}k
                                        </div>
                                        <span class="text-[10px] text-gray-700 truncate">{{ $bar['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Mensuel -->
                    <!-- ============================================== -->
                    <div id="tab-monthly" class="tab-content hidden">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-4">
                            <h4 class="text-md font-medium text-gray-700">Statistiques mensuelles</h4>
                            
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center w-full lg:w-auto space-y-2 sm:space-y-0 sm:space-x-2">
                                <input type="month" name="date" id="monthly-month"
                                    class="w-full sm:w-auto px-3 py-2 sm:py-1 border border-gray-300 rounded-md text-sm text-gray-900 focus:ring-green-500 focus:border-green-500"
                                    value="{{ request('date', now()->format('Y-m')) }}">
                                <input type="hidden" name="period" value="mois">
                                
                                <div class="flex w-full sm:w-auto space-x-2">
                                    <button type="submit" class="flex-1 sm:flex-none bg-primary-100 text-gray-700 px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-primary-200">
                                        Appliquer
                                    </button>
                                    <a href="{{ route('export.mois',['date' => request('date', date('Y-m-d'))]) }}"
                                        class="flex-1 sm:flex-none text-center bg-green-600 text-white px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-green-700">
                                        Exporter PDF
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                 <!-- Reste du tableau identique avec l'ajout de overflow-x-auto au wrapper -->
                                 <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Type d'engin</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Entrées</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sorties</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tarif</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($monthlyTableData as $stat)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $stat['label'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['entrees'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $stat['sorties'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['tarif'], 0, ',', ' ') }} FCFA</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($stat['revenu'], 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-semibold text-gray-900">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">Total</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $monthlyTotalEntrees }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $monthlyTotalSorties }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">–</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ number_format($monthlyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Graphique à intégrer ici en conservant "overflow-hidden" et "overflow-x-auto" pour les barres -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
                                <div class="flex justify-center items-start overflow-hidden">
                                  <svg viewBox="0 0 320 200" class="w-full max-w-sm h-auto">
                                    <!-- Logique du chart ici -->
                                  </svg>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 w-full overflow-hidden">
                                <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus mensuels</h5>
                                <div class="relative h-64 flex items-end justify-between px-2 sm:px-4 overflow-x-auto gap-2 pb-2">
                                    @foreach ($monthlyRevenusSegments as $bar)
                                    @php $height = $monthlyRevenuMax > 0 ? round(($bar['revenu'] / $monthlyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center min-w-[30px]">
                                        <div class="w-6 rounded-t mb-1 text-white text-[10px] text-center flex items-end justify-center pb-1"
                                            style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }}">
                                            {{ round($bar['revenu'] / 1000) }}k
                                        </div>
                                        <span class="text-[10px] text-gray-700 truncate">{{ $bar['label'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Annuel -->
                    <!-- ============================================== -->
                    <div id="tab-yearly" class="tab-content hidden">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-4">
                            <h4 class="text-md font-medium text-gray-700">Statistiques annuelles</h4>
                            
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center w-full lg:w-auto space-y-2 sm:space-y-0 sm:space-x-2">
                                <input type="number" name="date" id="yearly-year" min="2025" max="2100"
                                    class="w-full sm:w-auto px-3 py-2 sm:py-1 border border-gray-300 rounded-md text-sm text-gray-900 focus:ring-green-500 focus:border-green-500"
                                    value="{{ request('date', date('Y')) }}">
                                <input type="hidden" name="period" value="année">
                                
                                <div class="flex w-full sm:w-auto space-x-2">
                                    <button type="submit" class="flex-1 sm:flex-none bg-primary-100 text-gray-900 px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-primary-200">
                                        Appliquer
                                    </button>
                                    <a href="{{ route('export.annee',['date' => request('date', date('Y'))]) }}"
                                        class="flex-1 sm:flex-none text-center bg-green-600 text-white px-4 py-2 sm:py-1 rounded-md text-sm font-medium hover:bg-green-700">
                                        Exporter PDF
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <!-- Contenu similaire avec thead/tbody -->
                            </table>
                        </div>

                        <!-- Graphiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                             <!-- Graphiques ici avec overflow-x-auto sur le graphe en barre comme précédemment -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection