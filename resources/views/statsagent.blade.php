@extends('layouts.app')

      @section('content')


<div class="pt-28">
    <!-- Ici ton contenu principal -->


    <div class="mt-5">
    
  <!-- Dashboard Overview Section -->
<div id="dashboard" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 -mt-16 relative z-10">
    <div class="min-h-screen  " >
    <!-- Settings Section -->
        
@php
    // Valeurs par défaut si les variables ne sont pas définies
     $agentsData = $agentsData ?? [];
    $date = $date ?? now()->format('Y-m-d');
    $periode = $periode ?? 'jour';
@endphp

            <!-- Settings Section -->
          <!-- Settings Section -->
            <section id="settings-section" class="px-4 sm:px-0 ">
                <div class="mb-6">
              
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Statistiques par agent</h1>

    <div class="mb-4">
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ $date }}" class="border p-1 rounded text-gray-600">
            <select name="periode" class="border-green-900 p-1 rounded text-gray-600">
                <option value="jour" @if($periode=='jour') selected @endif>Jour</option>
                <option value="semaine" @if($periode=='semaine') selected @endif>Semaine</option>
                <option value="mois" @if($periode=='mois') selected @endif>Mois</option>
                <option value="année" @if($periode=='année') selected @endif>Année</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Filtrer</button>
        </form>
    </div>
    @php
    $agentsData = $agentsData ?? [];
    $date = $date ?? now()->format('Y-m-d');
    $periode = $periode ?? 'jour';
@endphp


   <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Agent</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Entrées</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Sorties</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Montant Total</th>
       
        </tr>
      </thead>
        <tbody>
            @foreach($agentsData as $data)
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $data['agent'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $data['total_entrees'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $data['total_sorties'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($data['montant_total'], 2) }} FCFA
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>

    <!-- VERSION MOBILE -->
    
</div>

            </section>
        </div>
    </div>
    </div>
    </div>
               </body>
</html>

    <script>
    
</script>

 
 
@endsection('content')