@extends('layouts.app')


@section('content')

  <div class="pt-28">
    <!-- Ici ton contenu principal -->

  <!-- Contenu principal -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded-lg shadow mt-4 text-gray-800">
    <h1 class="text-3xl font-bold mb-6">Historique des activités</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('recent') }}" class="mb-8 bg-white p-4 rounded-lg shadow-sm">
      <div class="flex flex-col sm:flex-row flex-wrap gap-4">
        <div class="flex flex-col w-full sm:w-48">
          <label for="plaque" class="mb-1 font-medium">Plaque</label>
          <input type="text" name="plaque" id="plaque" value="{{ request('plaque') }}"
            placeholder="Ex: ABC123"
            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
        </div>

        <div class="flex flex-col w-full sm:w-48">
          <label for="type" class="mb-1 font-medium">Type de véhicule</label>
          <select name="type" id="type"
            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">Tous</option>
            <option value="motorcycle" {{ request('type') == 'motorcycle' ? 'selected' : '' }}>Moto</option>
            <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Voiture</option>
            <option value="tricycle" {{ request('type') == 'tricycle' ? 'selected' : '' }}>Tricycle</option>
            <option value="nyonyovi" {{ request('type') == 'nyonyovi' ? 'selected' : '' }}>Nyonyovi</option>
            <option value="minibus" {{ request('type') == 'minibus' ? 'selected' : '' }}>Minibus</option>
            <option value="bus" {{ request('type') == 'bus' ? 'selected' : '' }}>Bus</option>
            <option value="truck" {{ request('type') == 'truck' ? 'selected' : '' }}>Camion</option>
          </select>
        </div>

        <div class="flex flex-col w-full sm:w-48">
          <label for="periode" class="mb-1 font-medium">Période</label>
          <select name="periode" id="periode"
            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">Toutes</option>
            <option value="jour" {{ request('periode') == 'jour' ? 'selected' : '' }}>Aujourd'hui</option>
            <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Cette semaine</option>
            <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Ce mois</option>
            <option value="année" {{ request('periode') == 'année' ? 'selected' : '' }}>Cette année</option>
          </select>
        </div>

        <div class="flex items-end">
          <button type="submit"
            class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Rechercher
          </button>
        </div>
      </div>
    </form>

    <!-- Tableau des activités -->
    <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5">
      <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Plaque</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Événement</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nom</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" translate="no"> Entrés </th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sorties</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Durée</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Voir</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
          @forelse ($activites as $act)
            <tr>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['date'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-900 font-semibold">{{ $act['plaque'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['evenement'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['name'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['type'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['entre'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['sortie'] }}</td>
              <td class="px-3 py-4 text-sm text-gray-700">{{ $act['duree'] }}</td>
              <td class="px-3 py-4 text-sm">
                @if ($act['statut'] === 'Complété')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                    {{ $act['statut'] }}
                  </span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                    {{ $act['statut'] }}
                  </span>
                @endif
              </td>
                <td class="px-3 py-4 text-sm text-center">
<!-- Lien pour ouvrir le modal -->
<td class="px-3 py-4 text-sm text-center">
    @if ($act['source'] === 'entree')
        <a href="{{ route('entres.show', $act['id']) }}"
           class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200 transition">
            Détails
        </a>
    @else ($act['source'] === 'sortie')
        <a href="{{ route('sorties.show', $act['id']) }}"
           class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200 transition">
            Détails
        </a>
    @endif
</td>


                    </td>
                  </tr>
                  @empty
                  <tr>
                  <td colspan="9" class="text-center py-6 text-sm text-gray-500">Aucune activité trouvée.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

                      <!-- Pagination -->
                 @if ($activites->hasPages())
              <div class="mt-6 flex justify-center">
              <ul class="inline-flex -space-x-px">
              {{-- Lien page précédente --}}
              @if ($activites->onFirstPage())
              <li>
              <span class="px-4 py-2 ml-0 text-gray-400 bg-white border border-green-500 rounded-l-lg cursor-not-allowed">‹</span>
              </li>
              @else
              <li>
              <a href="{{ $activites->previousPageUrl() }}" class="px-4 py-2 ml-0 text-green-500 bg-white border border-green-500 rounded-l-lg hover:bg-green-500 hover:text-white transition duration-200">‹</a>
              </li>
              @endif

               {{-- Liens des pages --}}
               @foreach ($activites->getUrlRange(1, $activites->lastPage()) as $page => $url)
               @if ($page == $activites->currentPage())
               <li><span class="px-4 py-2 text-white bg-green-500 border border-green-500 cursor-default">{{ $page }}</span></li>
              @else
              <li><a href="{{ $url }}" class="px-4 py-2 text-green-500 bg-white border border-green-500 hover:bg-green-500 hover:text-white transition duration-200">{{ $page }}</a></li>
             @endif
             @endforeach

             {{-- Lien page suivante --}}
            @if ($activites->hasMorePages())
            <li>
            <a href="{{ $activites->nextPageUrl() }}" class="px-4 py-2 text-green-500 bg-white border border-green-500 rounded-r-lg hover:bg-green-500 hover:text-white transition duration-200">›</a>
            </li>
            @else
            <li>
            <span class="px-4 py-2 text-gray-400 bg-white border border-green-500 rounded-r-lg cursor-not-allowed">›</span>
            </li>
            @endif
            </ul>
            </div>
            @endif
        </div>
      </div>
      <br>
</body>
</html>

@endsection





