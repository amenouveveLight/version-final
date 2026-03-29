@extends('layouts.app')

@section('content')

<div class="pt-16 md:pt-28 w-full">
    <!-- Ici ton contenu principal -->
    <div class="mt-2 md:mt-5 w-full">
        
        <!-- Dashboard Overview Section -->
        <div id="dashboard" class="w-full max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 py-2 sm:py-12">
            <div class="bg-white rounded-xl shadow-lg p-2 sm:p-6 md:p-8 sm:-mt-16 relative z-10 w-full">
                
                <!-- En-tête tableau de bord -->
                <div class="flex flex-row justify-between items-center mb-4 sm:mb-6 w-full">
                    <h2 class="text-base sm:text-2xl font-bold text-gray-800">Tableau de bord</h2>
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <span class="text-[9px] sm:text-sm text-gray-500 hidden sm:inline">Dernière mise à jour:</span>
                        <form method="GET" action="{{ route('dashboard') }}">
                            <button type="submit" class="p-1 sm:p-2 rounded-full hover:bg-gray-100" title="Rafraîchir les données">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats Cards (2 colonnes sur mobile, 4 sur PC pour conserver le style) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-8 w-full">
                    <!-- Card 1 -->
                    <div class="bg-white border border-gray-300 rounded-lg p-2 sm:p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[9px] sm:text-sm font-medium text-gray-500 truncate">Record journalier</h3>
                            <div class="hidden sm:flex h-6 w-6 sm:h-8 sm:w-8 bg-primary-100 rounded-full items-center justify-center shrink-0">
                                <svg class="h-3 w-3 sm:h-5 sm:w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H4m0 0a4 4 0 004-4V5m5 14h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6m0 0V5m0 6h4" />
                                </svg>
                            </div>
                        </div>
                        @if($topDailyEntry)
                            <p class="mt-1 sm:mt-2 text-sm sm:text-3xl font-bold text-gray-900">{{ $topDailyEntry->total }}</p>
                            <div class="mt-0 sm:mt-1 flex items-center text-[8px] sm:text-sm">
                                <span class="text-gray-500 truncate">le {{ \Carbon\Carbon::parse($topDailyEntry->date)->format('d/m/y') }}</span>
                            </div>
                        @else
                            <p class="mt-1 sm:mt-2 text-sm sm:text-3xl font-bold text-gray-400">–</p>
                            <div class="mt-0 sm:mt-1 flex items-center text-[8px] sm:text-sm">
                                <span class="text-gray-500">Aucune donnée</span>
                            </div>
                        @endif
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white border border-gray-300 rounded-lg p-2 sm:p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[9px] sm:text-sm font-medium text-gray-500 truncate">Places dispo.</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[8px] sm:text-sm">
                            <span class="{{ ($evolution_1h[0] === '+') ? 'text-green-600' : 'text-red-600' }}">{{ $evolution_1h }}</span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white border border-gray-300 rounded-lg p-2 sm:p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[9px] sm:text-sm font-medium text-gray-500 truncate">Places occupées</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[8px] sm:text-sm">
                            <span class="{{ ($evolution_occupees_1h < 0) ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h >= 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white border border-gray-300 rounded-lg p-2 sm:p-4 shadow-sm dashboard-card">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[9px] sm:text-sm font-medium text-gray-500 truncate">Taux occup.</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[8px] sm:text-sm">
                            <span class="{{ $evolution_occupees_1h < 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h > 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>
                </div>

                <!-- Section Statistiques -->
                <div class="mb-4 sm:mb-8 w-full">
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-2 sm:mb-4">Statistiques des engins</h3> 

                    <!-- Onglets (sur une seule ligne) -->
                    <div class="border-b border-gray-200 mb-2 sm:mb-4 w-full">
                        <ul class="flex w-full justify-between -mb-px text-[9px] sm:text-sm font-medium text-green-600">
                            <li class="flex-1 text-center">
                                <a href="#tab-daily" class="block w-full py-2 sm:p-4 border-b-2 font-semibold hover:text-green-600 hover:border-green-600 truncate">Jour</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-weekly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500 truncate">Semaine</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-monthly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500 truncate">Mois</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-yearly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 hover:border-green-600 border-transparent text-gray-500 truncate">Année</a>
                            </li>
                        </ul>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet "Statistiques du jour" -->
                    <!-- ============================================== -->
                    <div id="tab-daily" class="tab-content w-full">
                        <!-- Filtres en ligne stricte (flex-row) -->
                        <div class="flex flex-row justify-between items-center mb-2 sm:mb-4 w-full gap-1">
                            <h4 class="text-[10px] sm:text-md font-medium text-gray-700 hidden sm:block">Stats du jour</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center justify-end w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                                    class="px-1 sm:px-3 py-1 border border-green-300 rounded text-[9px] sm:text-sm text-gray-900 w-24 sm:w-auto hover:border-green-600">
                                <input type="hidden" name="period" value="jour">
                                <button type="submit" class="bg-primary-100 text-primary-700 px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-primary-200 text-gray-700">
                                    Appliquer
                                </button>
                                <a href="{{ route('export.jour', ['date' => request('date', date('Y-m-d'))]) }}" 
                                    class="bg-green-600 text-white px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-green-700">
                                    PDF
                                </a>
                            </form>
                        </div>

                        <!-- Tableau Forcé en colonnes -->
                        <div class="w-full overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg border border-gray-200">
                            <table class="w-full text-left border-collapse table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/4 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 truncate">Engin</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">In</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">Out</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Tarif</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 bg-white">
                                    @foreach ($dailyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-medium text-gray-900 truncate">{{ $stat['label'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['entrees'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['sorties'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-right truncate">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-bold text-green-700 text-right truncate">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-bold">
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-900">Total</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-900 text-center">{{ $dailyTotalEntrees }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-900 text-center">{{ $dailyTotalSorties }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-900 text-right">–</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-green-700 text-right truncate">{{ number_format($dailyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques 2 colonnes même sur mobile -->
                        <div class="grid grid-cols-2 gap-2 sm:gap-6 mt-4 sm:mt-6 w-full">
                            <!-- Graphique Circulaire -->
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col items-center border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Répartition entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[200px]">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                    @foreach ($dailyPieSegments as $s)
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30"
                                        stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($dailyPieSegments as $s)
                                    <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                    <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ substr($s['label'],0,7) }} ({{ $s['percent'] }}%)</text>
                                    @php $y += 20; @endphp
                                    @endforeach
                                </svg>
                            </div>

                            <!-- Graphique à barres -->
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col justify-end border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Revenus (FCFA)</h5>
                                <div class="relative h-24 sm:h-64 flex items-end justify-between px-1 w-full gap-1">
                                    @foreach ($dailyRevenusSegments as $bar)
                                    @php $height = $dailyRevenuMax > 0 ? round(($bar['revenu'] / $dailyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <!-- Utilisation de % pour la hauteur pour adapter à la taille de la boite -->
                                        <div class="w-full max-w-[12px] sm:max-w-[24px] rounded-t mb-1 text-white text-[6px] sm:text-[10px] text-center"
                                            style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }};">
                                        </div>
                                        <span class="text-[6px] sm:text-[10px] text-gray-700 truncate w-full text-center" title="{{ $bar['label'] }}">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Hebdomadaire -->
                    <!-- ============================================== -->
                    <div id="tab-weekly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-2 sm:mb-4 w-full gap-1">
                            <h4 class="text-[10px] sm:text-md font-medium text-gray-700 hidden sm:block">Stats hebdo</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center justify-end w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="week" name="date" id="weekly-week" class="px-1 sm:px-3 py-1 border border-gray-300 rounded text-[9px] sm:text-sm text-gray-900 w-28 sm:w-auto" value="{{ request('date', now()->format('Y') . '-W' . now()->format('W')) }}">
                                <input type="hidden" name="period" value="semaine">
                                <button type="submit" class="bg-primary-100 text-primary-700 px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-primary-200 text-gray-600">Appliquer</button> 
                                <a href="{{ route('export.semaine',['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-green-700">PDF</a>
                            </form>
                        </div>
                        <div class="w-full overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg border border-gray-200">
                            <table class="w-full text-left border-collapse table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/4 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 truncate">Engin</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">In</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">Out</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Tarif</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($weeklyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-medium text-gray-900 truncate">{{ $stat['label'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['entrees'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['sorties'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-right truncate">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-bold text-green-700 text-right truncate">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-bold text-gray-900">
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm">Total</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $weeklyTotalEntrees }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $weeklyTotalSorties }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-right">–</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-green-700 text-right truncate">{{ number_format($weeklyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-6 mt-4 sm:mt-6 w-full">
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col items-center border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Répartition entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[200px]">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                    @foreach ($weeklyPieSegments as $s)
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($weeklyPieSegments as $s)
                                    <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                    <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ substr($s['label'],0,7) }} ({{ $s['percent'] }}%)</text>
                                    @php $y += 20; @endphp
                                    @endforeach
                                </svg>
                            </div>
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col justify-end border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Revenus (FCFA)</h5>
                                <div class="relative h-24 sm:h-64 flex items-end justify-between px-1 w-full gap-1">
                                    @foreach ($weeklyRevenusSegments as $bar)
                                    @php $height = $weeklyRevenuMax > 0 ? round(($bar['revenu'] / $weeklyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full max-w-[12px] sm:max-w-[24px] rounded-t mb-1" style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }}"></div>
                                        <span class="text-[6px] sm:text-[10px] text-gray-700 truncate w-full text-center">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Mensuel -->
                    <!-- ============================================== -->
                    <div id="tab-monthly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-2 sm:mb-4 w-full gap-1">
                            <h4 class="text-[10px] sm:text-md font-medium text-gray-700 hidden sm:block">Stats mensuelles</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center justify-end w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="month" name="date" id="monthly-month" class="px-1 sm:px-3 py-1 border border-gray-300 rounded text-[9px] sm:text-sm text-gray-900 w-24 sm:w-auto" value="{{ request('date', now()->format('Y-m')) }}">
                                <input type="hidden" name="period" value="mois text-gray-600">
                                <button type="submit" class="bg-primary-100 text-primary-700 px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-primary-200 text-gray-600">Appliquer</button>
                                <a href="{{ route('export.mois', ['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-green-700">PDF</a>
                            </form>
                        </div>
                        <div class="w-full overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg border border-gray-200">
                            <table class="w-full text-left border-collapse table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/4 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 truncate">Engin</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">In</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">Out</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Tarif</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($monthlyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-medium text-gray-900 truncate">{{ $stat['label'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['entrees'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['sorties'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-right truncate">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-bold text-green-700 text-right truncate">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-bold text-gray-900">
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm">Total</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $monthlyTotalEntrees }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $monthlyTotalSorties }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-right">–</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-green-700 text-right truncate">{{ number_format($monthlyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-6 mt-4 sm:mt-6 w-full">
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col items-center border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Répartition entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[200px]">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                    @foreach ($monthlyPieSegments as $s)
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($monthlyPieSegments as $s)
                                    <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                    <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ substr($s['label'],0,7) }} ({{ $s['percent'] }}%)</text>
                                    @php $y += 20; @endphp
                                    @endforeach
                                </svg>
                            </div>
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col justify-end border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Revenus (FCFA)</h5>
                                <div class="relative h-24 sm:h-64 flex items-end justify-between px-1 w-full gap-1">
                                    @foreach ($monthlyRevenusSegments as $bar)
                                    @php $height = $monthlyRevenuMax > 0 ? round(($bar['revenu'] / $monthlyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full max-w-[12px] sm:max-w-[24px] rounded-t mb-1" style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }}"></div>
                                        <span class="text-[6px] sm:text-[10px] text-gray-700 truncate w-full text-center">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet Annuel -->
                    <!-- ============================================== -->
                    <div id="tab-yearly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-2 sm:mb-4 w-full gap-1">
                            <h4 class="text-[10px] sm:text-md font-medium text-gray-700 hidden sm:block">Stats annuelles</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center justify-end w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="number" name="date" id="yearly-year" min="2025" max="2100" value="{{ request('date', date('Y')) }}" class="px-1 sm:px-3 py-1 border border-gray-300 rounded text-[9px] sm:text-sm text-gray-900 w-16 sm:w-auto">
                                <input type="hidden" name="period" value="année">
                                <button type="submit" class="bg-primary-100 text-primary-700 px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-primary-200 text-gray-900">Appliquer</button>
                                <a href="{{ route('export.annee', ['date' => request('date', date('Y'))]) }}" class="bg-green-600 text-white px-2 sm:px-3 py-1 rounded text-[9px] sm:text-sm font-medium hover:bg-green-700">PDF</a>
                            </form>
                        </div>
                        <div class="w-full overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg border border-gray-200">
                            <table class="w-full text-left border-collapse table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/4 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 truncate">Engin</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">In</th>
                                        <th class="w-1/6 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-center truncate">Out</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Tarif</th>
                                        <th class="w-1/5 px-1 py-1 sm:px-3 sm:py-3.5 text-[8px] sm:text-sm font-semibold text-gray-900 text-right truncate">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($yearlyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-medium text-gray-900 truncate">{{ $stat['label'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['entrees'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-center truncate">{{ $stat['sorties'] }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-gray-700 text-right truncate">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="px-1 py-1.5 sm:px-3 sm:py-4 text-[8px] sm:text-sm font-bold text-green-700 text-right truncate">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-bold text-gray-900">
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm">Total</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $yearlyTotalEntrees }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-center">{{ $yearlyTotalSorties }}</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-right">–</td>
                                        <td class="px-1 py-2 sm:px-3 sm:py-4 text-[8px] sm:text-sm text-green-700 text-right truncate">{{ number_format($yearlyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="grid grid-cols-2 gap-2 sm:gap-6 mt-4 sm:mt-6 w-full">
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col items-center border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Répartition entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[200px]">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                    @foreach ($yearlyPieSegments as $s)
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($yearlyPieSegments as $s)
                                    <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                    <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ substr($s['label'],0,7) }} ({{ $s['percent'] }}%)</text>
                                    @php $y += 20; @endphp
                                    @endforeach
                                </svg>
                            </div>
                            <div class="bg-white p-2 sm:p-4 rounded-lg shadow-sm w-full flex flex-col justify-end border border-gray-200">
                                <h5 class="text-[8px] sm:text-sm font-medium text-gray-700 mb-2 sm:mb-4 text-center truncate w-full">Revenus (FCFA)</h5>
                                <div class="relative h-24 sm:h-64 flex items-end justify-between px-1 w-full gap-1">
                                    @foreach ($yearlyRevenusSegments as $bar)
                                    @php $height = $yearlyRevenuMax > 0 ? round(($bar['revenu'] / $yearlyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full max-w-[12px] sm:max-w-[24px] rounded-t mb-1" style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }}"></div>
                                        <span class="text-[6px] sm:text-[10px] text-gray-700 truncate w-full text-center">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection