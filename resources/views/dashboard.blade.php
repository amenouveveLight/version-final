@extends('layouts.app')

@section('content')

<div class="pt-16 md:pt-28">
    <!-- Contenu principal -->
    <div class="mt-2 md:mt-5">
        
        <!-- Dashboard Overview Section -->
        <div id="dashboard" class="w-full mx-auto px-1 sm:px-6 lg:px-8 py-2 md:py-12">
            <!-- p-2 sur mobile pour gagner de la place, p-8 sur PC -->
            <div class="bg-white rounded-xl shadow-lg p-2 sm:p-6 md:p-8 relative z-10 w-full">
                
                <!-- En-tête tableau de bord -->
                <div class="flex flex-row justify-between items-center mb-4 gap-2">
                    <h2 class="text-base sm:text-2xl font-bold text-gray-800">Tableau de bord</h2>
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <span class="text-[10px] sm:text-base text-gray-500 hidden sm:inline">Dernière mise à jour:</span>
                        <form method="GET" action="{{ route('dashboard') }}">
                            <button type="submit" class="p-1 sm:p-2 rounded-full bg-gray-100 hover:bg-gray-200" title="Rafraîchir">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats Cards : 2 colonnes sur mobile, 4 sur PC pour garder un look condensé -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-6 mb-6 w-full">
                    
                    <!-- Card 1 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-2 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 leading-tight">Record jour</h3>
                            <div class="hidden sm:flex h-8 w-8 bg-primary-100 rounded-full items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H4m0 0a4 4 0 004-4V5m5 14h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6m0 0V5m0 6h4" />
                                </svg>
                            </div>
                        </div>
                        @if($topDailyEntry)
                            <p class="mt-1 sm:mt-2 text-lg sm:text-3xl font-bold text-gray-900">{{ $topDailyEntry->total }}</p>
                            <span class="text-[9px] sm:text-sm text-gray-500 truncate block">le {{ \Carbon\Carbon::parse($topDailyEntry->date)->format('d/m/y') }}</span>
                        @else
                            <p class="mt-1 sm:mt-2 text-lg sm:text-3xl font-bold text-gray-400">–</p>
                        @endif
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-2 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 leading-tight">Places dispo.</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-lg sm:text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[9px] sm:text-sm">
                            <span class="{{ ($evolution_1h[0] === '+') ? 'text-green-600' : 'text-red-600' }}">{{ $evolution_1h }}</span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-2 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 leading-tight">Occupées</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-lg sm:text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[9px] sm:text-sm">
                            <span class="{{ ($evolution_occupees_1h < 0) ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h >= 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white border border-gray-200 rounded-lg p-2 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[10px] sm:text-sm font-medium text-gray-500 leading-tight">Taux occup.</h3>
                        </div>
                        <p class="mt-1 sm:mt-2 text-lg sm:text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>
                        <div class="mt-0 sm:mt-1 flex items-center text-[9px] sm:text-sm">
                            <span class="{{ $evolution_occupees_1h < 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $evolution_occupees_1h > 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
                            </span>
                            <span class="ml-1 text-gray-500">1h</span>
                        </div>
                    </div>
                </div>

                <!-- Section Statistiques -->
                <div class="mb-4 w-full">
                    <!-- Onglets : Affichés en ligne sur une seule ligne même sur mobile -->
                    <div class="border-b border-gray-200 mb-4">
                        <ul class="flex w-full justify-between -mb-px text-[11px] sm:text-sm font-medium text-green-600">
                            <li class="flex-1 text-center">
                                <a href="#tab-daily" class="block w-full py-2 sm:p-4 border-b-2 font-semibold hover:text-green-600 hover:border-green-600">Jour</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-weekly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 border-transparent text-gray-500">Semaine</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-monthly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 border-transparent text-gray-500">Mois</a>
                            </li>
                            <li class="flex-1 text-center">
                                <a href="#tab-yearly" class="block w-full py-2 sm:p-4 border-b-2 hover:text-green-600 border-transparent text-gray-500">Année</a>
                            </li>
                        </ul>
                    </div>

                    <!-- ============================================== -->
                    <!-- Onglet "Statistiques du jour" -->
                    <!-- ============================================== -->
                    <div id="tab-daily" class="tab-content w-full">
                        
                        <!-- Filtres en ligne même sur mobile -->
                        <div class="flex flex-row justify-between items-center mb-3 w-full gap-1 sm:gap-4">
                            <h4 class="text-xs sm:text-md font-medium text-gray-700 hidden sm:block">Stats du jour</h4>
                            
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                                    class="w-full sm:w-auto px-1 sm:px-3 py-1 sm:py-2 border border-green-300 rounded text-[10px] sm:text-sm text-gray-900">
                                <input type="hidden" name="period" value="jour">
                                
                                <button type="submit" class="bg-primary-100 px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium text-gray-700">
                                    Filtrer
                                </button>
                                <a href="{{ route('export.jour',['date' => request('date', date('Y-m-d'))]) }}" 
                                    class="bg-green-600 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">
                                    PDF
                                </a>
                            </form>
                        </div>

                        <!-- Tableau Forcé en colonnes (Même sur Mobile) -->
                        <div class="shadow rounded-lg border border-gray-200 bg-white w-full overflow-hidden">
                            <table class="w-full text-left border-collapse table-fixed sm:table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <!-- text-[9px] force un texte minuscule sur mobile pour que ça rentre -->
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-gray-900 w-1/4">Engin</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-gray-900 text-center">In</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-gray-900 text-center">Out</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-gray-900 text-right">Tarif</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-gray-900 text-right">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($dailyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-gray-900 truncate">{{ $stat['label'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-gray-700 text-center">{{ $stat['entrees'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-gray-700 text-center">{{ $stat['sorties'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-gray-700 text-right">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm font-medium text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-bold">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm">Total</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $dailyTotalEntrees }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $dailyTotalSorties }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">–</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-green-700 text-right">{{ number_format($dailyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Graphiques : 2 colonnes côte à côte même sur mobile -->
                        <div class="grid grid-cols-2 gap-2 sm:gap-4 mt-4 w-full">
                            <!-- Graphique Circulaire -->
                            <div class="bg-white p-2 sm:p-4 rounded shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                                <h5 class="text-[9px] sm:text-sm font-medium text-gray-700 mb-2 text-center leading-tight">Répartition entrées</h5>
                                <svg viewBox="0 0 320 200" class="w-full max-w-[200px] h-auto">
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
                                    @foreach ($dailyPieSegments as $s)
                                    <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30"
                                        stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" stroke-linecap="butt" />
                                    @endforeach
                                    @php $y = 20; @endphp
                                    @foreach ($dailyPieSegments as $s)
                                    <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
                                    <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">{{ $s['label'] }}</text>
                                    @php $y += 20; @endphp
                                    @endforeach
                                </svg>
                            </div>

                            <!-- Graphique à barres -->
                            <div class="bg-white p-2 sm:p-4 rounded shadow-sm border border-gray-100 flex flex-col justify-end">
                                <h5 class="text-[9px] sm:text-sm font-medium text-gray-700 mb-2 text-center leading-tight">Revenus (FCFA)</h5>
                                <div class="relative h-24 sm:h-48 flex items-end justify-between px-1 w-full gap-1">
                                    @foreach ($dailyRevenusSegments as $bar)
                                    @php $height = $dailyRevenuMax > 0 ? round(($bar['revenu'] / $dailyRevenuMax) * 100) : 0; @endphp
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full max-w-[16px] sm:max-w-[24px] rounded-t mb-1"
                                            style="height: {{ max($height, 5) }}%; background-color: {{ $bar['color'] }};">
                                        </div>
                                        <span class="text-[7px] sm:text-[10px] text-gray-700 w-full text-center truncate" title="{{ $bar['label'] }}">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- Reste des onglets (Hebdo, Mois, Année) construits sur le même modèle -->
                    <!-- ============================================== -->
                    <div id="tab-weekly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-3 w-full gap-1 sm:gap-4">
                            <h4 class="text-xs sm:text-md font-medium text-gray-700 hidden sm:block">Stats hebdo</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="week" name="date" value="{{ request('date', now()->format('Y') . '-W' . now()->format('W')) }}" 
                                    class="w-full sm:w-auto px-1 sm:px-3 py-1 sm:py-2 border rounded text-[10px] sm:text-sm">
                                <input type="hidden" name="period" value="semaine">
                                <button type="submit" class="bg-primary-100 px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">Filtrer</button>
                                <a href="{{ route('export.semaine',['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">PDF</a>
                            </form>
                        </div>
                        <div class="shadow rounded-lg border border-gray-200 bg-white w-full overflow-hidden">
                            <table class="w-full text-left border-collapse table-fixed sm:table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold w-1/4">Engin</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">In</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">Out</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Tarif</th>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($weeklyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm truncate">{{ $stat['label'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['entrees'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['sorties'] }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm font-medium text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-bold">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm">Total</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $weeklyTotalEntrees }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $weeklyTotalSorties }}</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">–</td>
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm text-green-700 text-right">{{ number_format($weeklyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mensuel -->
                    <div id="tab-monthly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-3 w-full gap-1 sm:gap-4">
                            <h4 class="text-xs sm:text-md font-medium text-gray-700 hidden sm:block">Stats mensuelles</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="month" name="date" value="{{ request('date', now()->format('Y-m')) }}" class="w-full sm:w-auto px-1 sm:px-3 py-1 sm:py-2 border rounded text-[10px] sm:text-sm">
                                <input type="hidden" name="period" value="mois">
                                <button type="submit" class="bg-primary-100 px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">Filtrer</button>
                                <a href="{{ route('export.mois',['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">PDF</a>
                            </form>
                        </div>
                        <div class="shadow rounded-lg border border-gray-200 bg-white w-full overflow-hidden">
                            <table class="w-full text-left border-collapse table-fixed sm:table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold w-1/4">Engin</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">In</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">Out</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Tarif</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($monthlyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm truncate">{{ $stat['label'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['entrees'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['sorties'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm font-medium text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-bold">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm">Total</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $monthlyTotalEntrees }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $monthlyTotalSorties }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">–</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-green-700 text-right">{{ number_format($monthlyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Annuel -->
                    <div id="tab-yearly" class="tab-content hidden w-full">
                        <div class="flex flex-row justify-between items-center mb-3 w-full gap-1 sm:gap-4">
                            <h4 class="text-xs sm:text-md font-medium text-gray-700 hidden sm:block">Stats annuelles</h4>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-row items-center w-full sm:w-auto gap-1 sm:gap-2">
                                <input type="number" name="date" min="2025" max="2100" value="{{ request('date', date('Y')) }}" class="w-full sm:w-auto px-1 sm:px-3 py-1 sm:py-2 border rounded text-[10px] sm:text-sm">
                                <input type="hidden" name="period" value="année">
                                <button type="submit" class="bg-primary-100 px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">Filtrer</button>
                                <a href="{{ route('export.annee',['date' => request('date', date('Y'))]) }}" class="bg-green-600 text-white px-2 sm:px-4 py-1 sm:py-2 rounded text-[10px] sm:text-sm font-medium">PDF</a>
                            </form>
                        </div>
                        <div class="shadow rounded-lg border border-gray-200 bg-white w-full overflow-hidden">
                            <table class="w-full text-left border-collapse table-fixed sm:table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold w-1/4">Engin</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">In</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-center">Out</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Tarif</th><th class="p-1 sm:p-3 text-[9px] sm:text-sm font-semibold text-right">Revenus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($yearlyTableData as $stat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm truncate">{{ $stat['label'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['entrees'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $stat['sorties'] }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">{{ number_format($stat['tarif'], 0, ',', ' ') }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm font-medium text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-bold">
                                        <td class="p-1 sm:p-3 text-[9px] sm:text-sm">Total</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $yearlyTotalEntrees }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-center">{{ $yearlyTotalSorties }}</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-right">–</td><td class="p-1 sm:p-3 text-[9px] sm:text-sm text-green-700 text-right">{{ number_format($yearlyRevenusTotaux, 0, ',', ' ') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection