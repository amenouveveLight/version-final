@extends('layouts.app')

@section('content')
<!-- Conteneur principal avec padding pour le menu fixe -->
<div class="pt-24 md:pt-32 pb-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Carte Blanche Principale -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Header de la page -->
            <div class="p-6 md:p-8 border-b border-gray-100 bg-white">
                <h1 class="text-2xl font-bold text-gray-900">📊 Statistiques par agent</h1>
                <p class="text-sm text-gray-500 mt-1">Vue d'ensemble des performances de l'équipe.</p>
            </div>

            <div class="p-6 md:p-8">
                @php
                    $agentsData = $agentsData ?? [];
                    $date = $date ?? now()->format('Y-m-d');
                    $periode = $periode ?? 'jour';
                @endphp

                <!-- Bloc des Filtres -->
                <div class="mb-8 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <form method="GET" action="{{ route('statsagent') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date</label>
                            <input type="date" name="date" value="{{ $date }}" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Période</label>
                            <select name="periode" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="jour" @if($periode=='jour') selected @endif>Jour</option>
                                <option value="semaine" @if($periode=='semaine') selected @endif>Semaine</option>
                                <option value="mois" @if($periode=='mois') selected @endif>Mois</option>
                                <option value="année" @if($periode=='année') selected @endif>Année</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition shadow-md">
                            Filtrer
                        </button>
                    </form>
                </div>

                <!-- 1. VERSION PC & TABLETTE (Visible uniquement sur grand écran) -->
                <div class="hidden md:block overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Agent</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Total Entrées</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Total Sorties</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Montant Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($agentsData as $data)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $data['agent'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600">{{ $data['total_entrees'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600">{{ $data['total_sorties'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black text-green-600">
                                    {{ number_format($data['montant_total'], 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Aucune donnée trouvée pour cette période.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- 2. VERSION MOBILE (Visible uniquement sur Smartphone) -->
                <div class="md:hidden space-y-4">
                    @forelse($agentsData as $data)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $data['agent'] }}</h3>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Actif</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 border-t border-gray-50 pt-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Entrées</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $data['total_entrees'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Sorties</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $data['total_sorties'] }}</p>
                            </div>
                            <div class="col-span-2 bg-green-50 p-3 rounded-lg mt-2">
                                <p class="text-[10px] font-bold text-green-600 uppercase">Recette totale</p>
                                <p class="text-xl font-black text-green-700">{{ number_format($data['montant_total'], 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 text-gray-400 italic">Aucune donnée trouvée.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Suppression des scripts complexes qui cachaient la vue -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Page de statistiques chargée");
    });
</script>
@endsection