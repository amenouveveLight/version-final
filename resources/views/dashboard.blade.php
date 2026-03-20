@extends('layouts.app')

      @section('content')


<div class="pt-28">
    <!-- Ici ton contenu principal -->

<div class="mt-5">
    
  <!-- Dashboard Overview Section -->
<div id="dashboard" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 -mt-16 relative z-10">
        <!-- En-tête tableau de bord -->
        <div class="flex justify-between items-start flex-col md:flex-row mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Tableau de bord</h2>
            <div class="flex items-center space-x-2">
                <span class="text-gray-500">Dernière mise à jour:</span>
               <!--  <span class="font-medium text-gray-500" id="last-update">Aujourd'hui à 15:30</span>-->
             <form method="GET" action="{{ route('dashboard') }}">
    <button type="submit" class="p-1 rounded-full hover:bg-gray-100" title="Rafraîchir les données">
        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
    </button>
</form>

            </div>
        </div>

        <!-- Sous-navigation -->
        

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Card 1 -->
        <div class="bg-white border border-gray-400 rounded-lg p-4 shadow-sm dashboard-card">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-gray-500">Record journalier</h3>
        <div class="h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center">
            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2a4 4 0 00-4-4H4m0 0a4 4 0 004-4V5m5 14h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6m0 0V5m0 6h4" />
            </svg>
        </div>
    </div>
    @if($topDailyEntry)
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $topDailyEntry->total }}</p>
        <div class="mt-1 flex items-center text-sm">
            <span class="text-gray-500">le {{ \Carbon\Carbon::parse($topDailyEntry->date)->format('d/m/Y') }}</span>
        </div>
    @else
        <p class="mt-2 text-3xl font-bold text-gray-400">–</p>
        <div class="mt-1 flex items-center text-sm">
            <span class="text-gray-500">Aucune donnée</span>
        </div>
    @endif
</div>


            <!-- Card 2 -->
  <div class="bg-white border border-gray-400 rounded-lg p-4 shadow-sm dashboard-card">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-gray-500">Places disponibles</h3>
        <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
        </div>
    </div>
    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $places_disponibles }}</p>
    <div class="mt-1 flex items-center text-sm">
        <span class="{{ ($evolution_1h[0] === '+') ? 'text-green-600' : 'text-red-600' }}">
            {{ $evolution_1h }}
        </span>
        <span class="ml-1 text-gray-500">depuis 1h</span>
    </div>
</div>


            <!-- Card 3 -->
          <div class="bg-white border border-gray-400 rounded-lg p-4 shadow-sm dashboard-card">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-gray-500">Places occupées</h3>
        <div class="h-8 w-8 bg-red-100 rounded-full flex items-center justify-center">
            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $places_occupees }}</p>
    <div class="mt-1 flex items-center text-sm">
        <span class="{{ ($evolution_occupees_1h < 0) ? 'text-red-600' : 'text-green-600' }}">
            {{ $evolution_occupees_1h >= 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
        </span>
        <span class="ml-1 text-gray-500">depuis 1h</span>
    </div>
</div>


            <!-- Card 4 -->
   <div class="bg-white border border-gray-400 rounded-lg p-4 shadow-sm dashboard-card">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-medium text-gray-500">Taux d'occupation</h3>
        <div class="h-8 w-8 bg-yellow-100 rounded-full flex items-center justify-center">
            <svg class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
    </div>

    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $taux_occupation }}%</p>

    <div class="mt-1 flex items-center text-sm">
        <span class="{{ $evolution_occupees_1h < 0 ? 'text-red-600' : 'text-green-600' }}">
            {{ $evolution_occupees_1h > 0 ? '+' : '' }}{{ $evolution_occupees_1h }}
        </span>
        <span class="ml-1 text-gray-500">depuis 1h</span>
    </div>
</div>
</div>

        <!-- Tableau récapitulatif des engins -->
  <div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des engins</h3> 
   

  <!-- Onglets -->
     <div class="border-b border-gray-200 mb-4">
    <!-- Exemple de navigation -->
<ul class="flex flex-wrap -mb-px text-sm font-medium text-green-600">
  <li class="mr-2">
    <a href="#tab-daily" class="inline-block p-4 border-b-2 font-semibold hover:text-green-600 hover:border-green-600">Journalier</a>
  </li>
  <li class="mr-2">
    <a href="#tab-weekly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600">Hebdomadaire</a>
  </li>
  <li class="mr-2">
    <a href="#tab-monthly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600">Mensuel</a>
  </li>
  <li>
    <a href="#tab-yearly" class="inline-block p-4 border-b-2 hover:text-green-600 hover:border-green-600">Annuel</a>
  </li>
</ul>

     </div>

  <!-- Contenu de l'onglet "Statistiques du jour" -->
  <div id="tab-daily" class="tab-content">
    <!-- Filtre date -->
    <div class="flex justify-between items-center mb-4">
      <h4 class="text-md font-medium text-gray-700">Statistiques du jour</h4>
      <div class="flex items-center space-x-2">
  <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-2">
    <!-- Sélecteur de date -->
    <input 
        type="date" 
        name="date" 
        value="{{ request('date', date('Y-m-d')) }}" 
        class="px-3 py-1 border-green-600 border-green-300 rounded-md text-sm text-gray-900  hover:border-green-600"
    >

    <!-- Bouton appliquer -->
    <button 
        type="submit" 
        class="bg-primary-100 text-primary-700 px-3 py-1 rounded-md text-sm font-medium hover:bg-primary-200 text-gray-700"
    >
        Appliquer
    </button>

    <!-- Bouton exporter -->
    <a 
        href="{{ route('export.jour', ['date' => request('date', date('Y-m-d'))]) }}" 
        class="bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-green-700"
    >
        Exporter PDF
    </a>

    <input type="hidden" name="period" value="jour">
</form>

      </div>
    </div>

    <!-- Tableau des données -->
 <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
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
            <td class="whitedarkspace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $stat['label'] }}</td>
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


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
      <!-- Graphique Circulaire -->
      <div class="bg-white p-4 rounded-lg shadow-sm w-full">
        <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
        <div class="flex justify-center items-start">
          <svg viewBox="0 0 320 200" class="w-full h-64">
            <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
            @foreach ($dailyPieSegments as $s)
              <circle
                cx="100" cy="100" r="80"
                fill="none"
                stroke="{{ $s['color'] }}"
                stroke-width="30"
                stroke-dasharray="{{ $s['dasharray'] }}"
                stroke-dashoffset="{{ $s['dashoffset'] }}"
                stroke-linecap="butt"
              />
            @endforeach
            @php $y = 20; @endphp
            @foreach ($dailyPieSegments as $s)
              <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
              <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">
                {{ $s['label'] }} ({{ $s['percent'] }}%)
              </text>
              @php $y += 20; @endphp
            @endforeach
          </svg>
        </div>
      </div>

      <!-- Graphique à barres -->
       <div class="bg-white p-4 rounded-lg shadow-sm">
      <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus journalier</h5>
      <div class="relative h-64 flex items-end justify-between px-4">
    @foreach ($dailyRevenusSegments as $bar)
  @php
    $height = $dailyRevenuMax > 0 ? round(($bar['revenu'] / $dailyRevenuMax) * 100) : 0;
  @endphp
  <div class="flex flex-col items-center">
    <div
      class="w-6 rounded-t mb-1 text-white text-[10px] text-center"
      style="height: {{ $height }}px; background-color: {{ $bar['color'] }};"
    >
      {{ number_format($bar['revenu'], 0, ',', ' ') }} FCFA
    </div>
    <span class="text-[10px] text-gray-700">{{ $bar['label'] }}</span>
  </div>
@endforeach
      </div>
    </div>
    </div>
  </div>
</div>
<!-- Onglet Hebdomadaire -->
<div id="tab-weekly" class="tab-content">
  <!-- En-tête -->
  <div class="flex justify-between items-center mb-4">
    <h4 class="text-md font-medium text-gray-700">Statistiques hebdomadaires</h4>
    <div class="flex items-center space-x-2">
   <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-2">
      <input
       type="week"
       name="date"
       id="weekly-week"
       class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-900"
       value="{{ request('date', now()->format('Y') . '-W' . now()->format('W')) }}">
  <input type="hidden" name="period" value="semaine">
  <button
    type="submit"
    class="bg-primary-100 text-primary-700 px-3 py-1 rounded-md text-sm font-medium hover:bg-primary-200 text-gray-600"
  >
    Appliquer
  </button> 
  <!-- Bouton exporter -->
    <a 
        href="{{ route('export.semaine', ['date' => request('date', date('Y-m-d'))]) }}" 
        class="bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-green-700"
    >
        Exporter PDF
    </a>
</form>


    </div>
  </div>

  <!-- Tableau -->
  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
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
      <div class="bg-white p-4 rounded-lg shadow-sm w-full">
        <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
        <div class="flex justify-center items-start">
          <svg viewBox="0 0 320 200" class="w-full h-64">
            <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
            @foreach ($weeklyPieSegments as $s)
              <circle
                cx="100" cy="100" r="80"
                fill="none"
                stroke="{{ $s['color'] }}"
                stroke-width="30"
                stroke-dasharray="{{ $s['dasharray'] }}"
                stroke-dashoffset="{{ $s['dashoffset'] }}"
                stroke-linecap="butt"
              />
            @endforeach
            @php $y = 20; @endphp
            @foreach ($weeklyPieSegments as $s)
              <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
              <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">
                {{ $s['label'] }} ({{ $s['percent'] }}%)
              </text>
              @php $y += 20; @endphp
            @endforeach
          </svg>
        </div>
      </div>


    <!-- Graphique à barres -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
      <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus hebdomadaires</h5>
      <div class="relative h-64 flex items-end justify-between px-4">
        @foreach ($weeklyRevenusSegments as $bar)
          @php
            $height = $weeklyRevenuMax > 0 ? round(($bar['revenu'] / $weeklyRevenuMax) * 100) : 0;
          @endphp
          <div class="flex flex-col items-center">
           <div
           class="w-6 rounded-t mb-1 text-white text-[10px] text-center"
           style="height: {{ $height }}px; background-color: {{ $bar['color'] }}">
             {{ round($bar['revenu'] / 1000) }}k
           </div>
           <span class="text-[10px] text-gray-700">{{ $bar['label'] }}</span>
           </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<div id="tab-monthly" class="tab-content">
  <div class="flex justify-between items-center mb-4">
    <h4 class="text-md font-medium text-gray-700">Statistiques mensuelles</h4>
    <div class="flex items-center space-x-2">
   <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-2">
  <input
    type="month"
    name="date"
    id="monthly-month"
    class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-900"
    value="{{ request('date', now()->format('Y-m')) }}"
  >
  <input type="hidden" name="period" value="mois text-gray-600">
  <button
    type="submit"
    class="bg-primary-100 text-primary-700 px-3 py-1 rounded-md text-sm font-medium hover:bg-primary-200 text-gray-600"
  >
    Appliquer
  </button>
  <!-- Bouton exporter -->
    <a 
        href="{{ route('export.mois', ['date' => request('date', date('Y-m-d'))]) }}" 
        class="bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-green-700"
    >
        Exporter PDF
    </a>
</form>

    </div>
  </div>

  <!-- Tableau -->
  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
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
   <!-- Graphique Circulaire -->
      <div class="bg-white p-4 rounded-lg shadow-sm w-full">
        <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
        <div class="flex justify-center items-start">
          <svg viewBox="0 0 320 200" class="w-full h-64">
            <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
            @foreach ($monthlyPieSegments as $s)
              <circle
                cx="100" cy="100" r="80"
                fill="none"
                stroke="{{ $s['color'] }}"
                stroke-width="30"
                stroke-dasharray="{{ $s['dasharray'] }}"
                stroke-dashoffset="{{ $s['dashoffset'] }}"
                stroke-linecap="butt"
              />
            @endforeach
            @php $y = 20; @endphp
            @foreach ($monthlyPieSegments as $s)
              <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
              <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">
                {{ $s['label'] }} ({{ $s['percent'] }}%)
              </text>
              @php $y += 20; @endphp
            @endforeach
          </svg>
        </div>
      </div>

    <!-- Graphique à barres -->
       <div class="bg-white p-4 rounded-lg shadow-sm">
      <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus mensuelles</h5>
      <div class="relative h-64 flex items-end justify-between px-4">
        @foreach ($monthlyRevenusSegments as $bar)
          @php
            $height = $monthlyRevenuMax > 0 ? round(($bar['revenu'] / $monthlyRevenuMax) * 100) : 0;
          @endphp
          <div class="flex flex-col items-center">
           <div
           class="w-6 rounded-t mb-1 text-white text-[10px] text-center"
           style="height: {{ $height }}px; background-color: {{ $bar['color'] }}">
             {{ round($bar['revenu'] / 1000) }}k
           </div>
           <span class="text-[10px] text-gray-700">{{ $bar['label'] }}</span>
           </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div id="tab-yearly" class="tab-content">
  <div class="flex justify-between items-center mb-4">
    <h4 class="text-md font-medium text-gray-700">Statistiques annuelles</h4>
    <div class="flex items-center space-x-2">
   <form method="GET" action="{{ route('dashboard') }}" class="flex items-center space-x-2">
  <input
    type="number"
    name="date"
    id="yearly-year"
    min="2025"
    max="2100"
    value="{{ request('date', date('Y')) }}"
    class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-900"
  >
  <input type="hidden" name="period" value="année">
  <button
    type="submit"
    class="bg-primary-100 text-primary-700 px-3 py-1 rounded-md text-sm font-medium hover:bg-primary-200 text-gray-900"
  >
    Appliquer
  </button>
  <!-- Bouton exporter -->
    <a 
        href="{{ route('export.annee', ['date' => request('date', date('Y'))]) }}" 
        class="bg-green-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-green-700"
    >
        Exporter PDF
    </a>
</form>

    </div>
  </div>

  <!-- Tableau -->
  <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
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
      <tbody class="divide-y divide-gray-200 bg-white">
        @foreach ($yearlyTableData as $stat)
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
          <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $yearlyTotalEntrees }}</td>
          <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $yearlyTotalSorties }}</td>
          <td class="whitespace-nowrap px-3 py-4 text-sm">–</td>
          <td class="whitespace-nowrap px-3 py-4 text-sm"> {{ number_format($yearlyRevenusTotaux, 0, ',', ' ') }} FCFA </td>
        </tr>
      </tbody>
    </table>
  </div>
<!-- Graphiques -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <!-- Graphique Circulaire -->
      <div class="bg-white p-4 rounded-lg shadow-sm w-full">
        <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Répartition des entrées par type d'engin</h5>
        <div class="flex justify-center items-start">
          <svg viewBox="0 0 320 200" class="w-full h-64">
            <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="30" />
            @foreach ($yearlyPieSegments as $s)
              <circle
                cx="100" cy="100" r="80"
                fill="none"
                stroke="{{ $s['color'] }}"
                stroke-width="30"
                stroke-dasharray="{{ $s['dasharray'] }}"
                stroke-dashoffset="{{ $s['dashoffset'] }}"
                stroke-linecap="butt"
              />
            @endforeach
            @php $y = 20; @endphp
            @foreach ($yearlyPieSegments as $s)
              <rect x="210" y="{{ $y }}" width="12" height="12" fill="{{ $s['color'] }}" />
              <text x="228" y="{{ $y + 10 }}" font-size="11" fill="#374151">
                {{ $s['label'] }} ({{ $s['percent'] }}%)
              </text>
              @php $y += 20; @endphp
            @endforeach
          </svg>
        </div>
      </div>


    <!-- Graphique à barres -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
      <h5 class="text-sm font-medium text-gray-700 mb-4 text-center">Revenus annuelles</h5>
      <div class="relative h-64 flex items-end justify-between px-4">
        @foreach ($yearlyRevenusSegments as $bar)
          @php
            $height = $yearlyRevenuMax > 0 ? round(($bar['revenu'] / $yearlyRevenuMax) * 100) : 0;
          @endphp
          <div class="flex flex-col items-center">
           <div
           class="w-6 rounded-t mb-1 text-white text-[10px] text-center"
           style="height: {{ $height }}px; background-color: {{ $bar['color'] }}">
             {{ round($bar['revenu'] / 1000) }}k
           </div>
           <span class="text-[10px] text-gray-700">{{ $bar['label'] }}</span>
           </div>
        @endforeach
      </div>
    </div>
  </div>
  
</div>


 <!-- <h3 class="text-xl font-bold text-gray-800 mb-6">Prévisions automatiques</h3>  -->

  

    
    <!-- Prévision hebdomadaire 
    <div class="bg-white rounded-lg shadow p-4">
      <h4 class="text-sm font-medium text-gray-600 mb-3">Prévision hebdomadaire</h4>
      <canvas id="weeklyChart" height="150"></canvas>
      <div class="mt-3 text-green-600 text-sm font-semibold">
        +15% par rapport à la semaine dernière
      </div>
    </div>
    
    <!-- Prévision mensuelle
    <div class="bg-white rounded-lg shadow p-4">
      <h4 class="text-sm font-medium text-gray-600 mb-3">Prévision mensuelle</h4>
      <canvas id="monthlyChart" height="150"></canvas>
      <div class="mt-3 text-orange-600 text-sm font-semibold">
        -8% sous l'objectif mensuel
      </div>
    </div>
    
    <!-- Prévision annuelle 
    <div class="bg-white rounded-lg shadow p-4">
      <h4 class="text-sm font-medium text-gray-600 mb-3">Prévision annuelle</h4>
      <canvas id="yearlyChart" height="150"></canvas>
      <div class="mt-3 text-green-600 text-sm font-semibold">
        +20% par rapport à l'année dernière
      </div>
    </div>
    
  </div>
</div>
                 
        --> 
</div>        
</body>
</html>
@endsection('content')