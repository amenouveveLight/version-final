@extends('layouts.app')

@section('content')

<div class="pt-16 md:pt-28 w-full bg-gray-50 min-h-screen">
    <div class="mt-2 md:mt-5 w-full">
        
        <!-- Dashboard Overview Section -->
        <div id="dashboard" class="w-full max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-2 sm:py-12">
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 md:p-8 sm:-mt-16 relative z-10 w-full border border-gray-100">
                
                <!-- 1. EN-TETE ET STATS GLOBALES (Inchangé) -->
                <div class="flex flex-row justify-between items-center mb-6 w-full">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Tableau de bord</h2>
                    <form method="GET" action="{{ route('dashboard') }}">
                        <button type="submit" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-8 w-full">
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase">Record Jour</h3>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $topDailyEntry->total ?? '0' }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase">Places Dispo.</h3>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase">Occupées</h3>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-3 sm:p-5 shadow-sm">
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase">Taux Occ.</h3>
                        <p class="text-lg sm:text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>
                    </div>
                </div>

                <!-- 2. NAVIGATION DES ONGLETS -->
                <div class="border-b border-gray-200 mb-6 overflow-x-auto">
                    <ul class="flex flex-nowrap sm:space-x-8 -mb-px text-center min-w-max">
                        <li class="flex-1">
                            <a href="#tab-daily" class="tab-link block py-4 px-4 border-b-2 border-green-600 text-green-600 font-bold text-xs sm:text-sm">JOURNALIER</a>
                        </li>
                        <li class="flex-1">
                            <a href="#tab-weekly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm">HEBDOMADAIRE</a>
                        </li>
                        <li class="flex-1">
                            <a href="#tab-monthly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm">MENSUEL</a>
                        </li>
                        <li class="flex-1">
                            <a href="#tab-yearly" class="tab-link block py-4 px-4 border-b-2 border-transparent text-gray-500 hover:text-green-600 text-xs sm:text-sm">ANNUEL</a>
                        </li>
                    </ul>
                </div>

                <!-- ============================================== -->
                <!-- 3. CONTENU DES ONGLETS ÉCRITS UN PAR UN -->
                <!-- ============================================== -->

                <!-- --- ONGLET JOURNALIER --- -->
                <div id="tab-daily" class="tab-content animate-fadeIn">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">
                        <h4 class="text-sm font-bold text-gray-700 uppercase">Statistiques du Jour</h4>
                        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="px-2 py-1 border border-gray-300 rounded text-xs">
                            <input type="hidden" name="period" value="jour">
                            <button type="submit" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold">Appliquer</button>
                            <a href="{{ route('export.jour', ['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">PDF</a>
                        </form>
                    </div>
                    <!-- Tableau Journalier -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Engins</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Entrées</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Sorties</th>
                                    <th class="px-3 py-3 text-right text-[10px] font-bold text-green-700 uppercase">Revenus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($dailyTableData as $stat)
                                <tr>
                                    <td class="px-3 py-3 text-xs sm:text-sm font-medium">{{ $stat['label'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['entrees'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['sorties'] }}</td>
                                    <td class="px-3 py-3 text-xs font-bold text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-100 font-bold">
                                    <td class="px-3 py-3 text-xs">TOTAL</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $dailyTotalEntrees }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $dailyTotalSorties }}</td>
                                    <td class="px-3 py-3 text-xs text-green-700 text-right">{{ number_format($dailyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Graphiques Journaliers -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-4 border rounded-lg flex flex-col items-center">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase">Répartition Entrées (Jour)</h5>
                            <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[300px]">
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#f3f4f6" stroke-width="30" />
                                @foreach ($dailyPieSegments as $s)
                                <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" />
                                @endforeach
                            </svg>
                        </div>
                        <div class="bg-white p-4 border rounded-lg">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase text-center">Revenus par type (Jour)</h5>
                            <div class="h-48 flex items-end justify-around border-b gap-1">
                                @foreach ($dailyRevenusSegments as $bar)
                                    @php $h = $dailyRevenuMax > 0 ? round(($bar['revenu'] / $dailyRevenuMax) * 100) : 0; @endphp
                                    <div class="w-full flex flex-col items-center">
                                        <div class="w-full max-w-[20px] rounded-t" style="height: {{ max($h, 2) }}%; background-color: {{ $bar['color'] }};"></div>
                                        <span class="text-[8px] mt-2 font-bold">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --- ONGLET HEBDOMADAIRE --- -->
                <div id="tab-weekly" class="tab-content hidden animate-fadeIn">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">
                        <h4 class="text-sm font-bold text-gray-700 uppercase">Statistiques Hebdo</h4>
                        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <input type="week" name="date" value="{{ request('date', date('Y-\WW')) }}" class="px-2 py-1 border border-gray-300 rounded text-xs">
                            <input type="hidden" name="period" value="semaine">
                            <button type="submit" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold">Appliquer</button>
                            <a href="{{ route('export.semaine', ['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">PDF</a>
                        </form>
                    </div>
                    <!-- Tableau Hebdo -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Engins</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Entrées</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Sorties</th>
                                    <th class="px-3 py-3 text-right text-[10px] font-bold text-green-700 uppercase">Revenus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($weeklyTableData as $stat)
                                <tr>
                                    <td class="px-3 py-3 text-xs sm:text-sm font-medium">{{ $stat['label'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['entrees'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['sorties'] }}</td>
                                    <td class="px-3 py-3 text-xs font-bold text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-100 font-bold">
                                    <td class="px-3 py-3 text-xs">TOTAL</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $weeklyTotalEntrees }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $weeklyTotalSorties }}</td>
                                    <td class="px-3 py-3 text-xs text-green-700 text-right">{{ number_format($weeklyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Graphiques Hebdo -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-4 border rounded-lg flex flex-col items-center">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase">Répartition Entrées (Hebdo)</h5>
                            <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[300px]">
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#f3f4f6" stroke-width="30" />
                                @foreach ($weeklyPieSegments as $s)
                                <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" />
                                @endforeach
                            </svg>
                        </div>
                        <div class="bg-white p-4 border rounded-lg">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase text-center">Revenus par type (Hebdo)</h5>
                            <div class="h-48 flex items-end justify-around border-b gap-1">
                                @foreach ($weeklyRevenusSegments as $bar)
                                    @php $h = $weeklyRevenuMax > 0 ? round(($bar['revenu'] / $weeklyRevenuMax) * 100) : 0; @endphp
                                    <div class="w-full flex flex-col items-center">
                                        <div class="w-full max-w-[20px] rounded-t" style="height: {{ max($h, 2) }}%; background-color: {{ $bar['color'] }};"></div>
                                        <span class="text-[8px] mt-2 font-bold">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --- ONGLET MENSUEL --- -->
                <div id="tab-monthly" class="tab-content hidden animate-fadeIn">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">
                        <h4 class="text-sm font-bold text-gray-700 uppercase">Statistiques Mensuelles</h4>
                        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <input type="month" name="date" value="{{ request('date', date('Y-m')) }}" class="px-2 py-1 border border-gray-300 rounded text-xs">
                            <input type="hidden" name="period" value="mois">
                            <button type="submit" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold">Appliquer</button>
                            <a href="{{ route('export.mois', ['date' => request('date', date('Y-m-d'))]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">PDF</a>
                        </form>
                    </div>
                    <!-- Tableau Mensuel -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Engins</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Entrées</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Sorties</th>
                                    <th class="px-3 py-3 text-right text-[10px] font-bold text-green-700 uppercase">Revenus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($monthlyTableData as $stat)
                                <tr>
                                    <td class="px-3 py-3 text-xs sm:text-sm font-medium">{{ $stat['label'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['entrees'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['sorties'] }}</td>
                                    <td class="px-3 py-3 text-xs font-bold text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-100 font-bold">
                                    <td class="px-3 py-3 text-xs">TOTAL</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $monthlyTotalEntrees }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $monthlyTotalSorties }}</td>
                                    <td class="px-3 py-3 text-xs text-green-700 text-right">{{ number_format($monthlyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Graphiques Mensuels -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-4 border rounded-lg flex flex-col items-center">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase">Répartition Entrées (Mois)</h5>
                            <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[300px]">
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#f3f4f6" stroke-width="30" />
                                @foreach ($monthlyPieSegments as $s)
                                <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" />
                                @endforeach
                            </svg>
                        </div>
                        <div class="bg-white p-4 border rounded-lg">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase text-center">Revenus par type (Mois)</h5>
                            <div class="h-48 flex items-end justify-around border-b gap-1">
                                @foreach ($monthlyRevenusSegments as $bar)
                                    @php $h = $monthlyRevenuMax > 0 ? round(($bar['revenu'] / $monthlyRevenuMax) * 100) : 0; @endphp
                                    <div class="w-full flex flex-col items-center">
                                        <div class="w-full max-w-[20px] rounded-t" style="height: {{ max($h, 2) }}%; background-color: {{ $bar['color'] }};"></div>
                                        <span class="text-[8px] mt-2 font-bold">{{ substr($bar['label'], 0, 3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --- ONGLET ANNUEL --- -->
                <div id="tab-yearly" class="tab-content hidden animate-fadeIn">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">
                        <h4 class="text-sm font-bold text-gray-700 uppercase">Statistiques Annuelles</h4>
                        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <input type="number" name="date" value="{{ request('date', date('Y')) }}" min="2000" max="2100" class="px-2 py-1 border border-gray-300 rounded text-xs">
                            <input type="hidden" name="period" value="année">
                            <button type="submit" class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-xs font-bold">Appliquer</button>
                            <a href="{{ route('export.annee', ['date' => request('date', date('Y'))]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">PDF</a>
                        </form>
                    </div>
                    <!-- Tableau Annuel -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-[10px] font-bold text-gray-500 uppercase">Engins</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Entrées</th>
                                    <th class="px-3 py-3 text-center text-[10px] font-bold text-gray-500 uppercase">Sorties</th>
                                    <th class="px-3 py-3 text-right text-[10px] font-bold text-green-700 uppercase">Revenus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($yearlyTableData as $stat)
                                <tr>
                                    <td class="px-3 py-3 text-xs sm:text-sm font-medium">{{ $stat['label'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['entrees'] }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $stat['sorties'] }}</td>
                                    <td class="px-3 py-3 text-xs font-bold text-green-700 text-right">{{ number_format($stat['revenu'], 0, ',', ' ') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-100 font-bold">
                                    <td class="px-3 py-3 text-xs">TOTAL</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $yearlyTotalEntrees }}</td>
                                    <td class="px-3 py-3 text-xs text-center">{{ $yearlyTotalSorties }}</td>
                                    <td class="px-3 py-3 text-xs text-green-700 text-right">{{ number_format($yearlyRevenusTotaux, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Graphiques Annuels -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-4 border rounded-lg flex flex-col items-center">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase">Répartition Entrées (An)</h5>
                            <svg viewBox="0 0 320 200" class="w-full h-auto max-w-[300px]">
                                <circle cx="100" cy="100" r="80" fill="none" stroke="#f3f4f6" stroke-width="30" />
                                @foreach ($yearlyPieSegments as $s)
                                <circle cx="100" cy="100" r="80" fill="none" stroke="{{ $s['color'] }}" stroke-width="30" stroke-dasharray="{{ $s['dasharray'] }}" stroke-dashoffset="{{ $s['dashoffset'] }}" />
                                @endforeach
                            </svg>
                        </div>
                        <div class="bg-white p-4 border rounded-lg">
                            <h5 class="text-[10px] font-bold text-gray-400 mb-4 uppercase text-center">Revenus par type (An)</h5>
                            <div class="h-48 flex items-end justify-around border-b gap-1">
                                @foreach ($yearlyRevenusSegments as $bar)
                                    @php $h = $yearlyRevenuMax > 0 ? round(($bar['revenu'] / $yearlyRevenuMax) * 100) : 0; @endphp
                                    <div class="w-full flex flex-col items-center">
                                        <div class="w-full max-w-[20px] rounded-t" style="height: {{ max($h, 2) }}%; background-color: {{ $bar['color'] }};"></div>
                                        <span class="text-[8px] mt-2 font-bold">{{ substr($bar['label'], 0, 3) }}</span>
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

                contents.forEach(c => c.classList.add('hidden'));
                tabs.forEach(t => {
                    t.classList.remove('border-green-600', 'text-green-600', 'font-bold');
                    t.classList.add('border-transparent', 'text-gray-500');
                });

                document.getElementById(targetId).classList.remove('hidden');
                this.classList.add('border-green-600', 'text-green-600', 'font-bold');
                this.classList.remove('border-transparent', 'text-gray-500');
            });
        });

        // Maintenir l'onglet après filtrage
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