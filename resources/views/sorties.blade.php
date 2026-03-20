@extends ('layouts.app')

@section('content')
  <!-- Conteneurs -->
   <div class="pt-28">
    <!-- Ici ton contenu principal -->

<div class="mt-3 flex justify-center">
  <div id="exit-form-container" class="bg-white text-gray-800 p-6 rounded-xl shadow-md w-full max-w-3xl">

    <h3 class="text-xl font-bold text-gray-900 mb-6">Enregistrer une sortie</h3>

    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
      </div>
    @endif

    <!-- Formulaire de recherche par plaque -->
    <form action="{{ route('sorties.create') }}" method="GET" class="mb-6">
      <label for="plaque" class="block text-sm font-medium text-gray-700">Plaque du véhicule</label>
      <input type="text" name="plaque" id="plaque" placeholder="Ex : AB-123-CD"
             value="{{ old('plaque', $plaque ?? '') }}"
             onchange="this.form.submit()"
             required
             class="mt-1 w-full px-4 py-2 border border-gray-300 rounded shadow-sm text-base bg-gray-50 focus:ring-green-600 focus:border-green-600">
      @error('plaque')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </form>

    @if(!empty($typesDisponibles))
      <!-- Formulaire d’enregistrement de sortie -->
      <form method="POST" action="{{ route('sorties.store') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="plaque" value="{{ old('plaque', $plaque ?? '') }}">

        <!-- Type de véhicule -->
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700">Type de véhicule</label>
          <select name="type" id="type" required onchange="updateMontant()"
                  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded shadow-sm text-base focus:ring-green-600 focus:border-green-600 bg-white">
            <option value="">-- Sélectionnez --</option>
            @foreach ($types as $val => $infos)
              @if(in_array($val, $typesDisponibles))
                <option value="{{ $val }}" {{ (old('type', $dernierType ?? '') === $val) ? 'selected' : '' }}>
                  {{ $infos['label'] }}
                </option>
              @endif
            @endforeach
          </select>
          @error('type')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Montant affiché (lecture seule) -->
        <div>
          <label for="montant" class="block text-sm font-medium text-gray-700">Montant (FCFA)</label>
          <input type="text" name="montant" id="montant" value="{{ $montant ?? '—' }}" readonly
                 class="mt-1 w-full px-4 py-2 border bg-gray-100 text-gray-800 rounded">
        </div>

        <!-- Méthode de paiement -->
        <div>
          <label for="paiement" class="block text-sm font-medium text-gray-700">Méthode de paiement</label>
          <select name="paiement" id="paiement" required
                  class="mt-1 w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:ring-green-600 focus:border-green-600">
            <option value="">-- Choisir --</option>
            @foreach(['cash' => 'Espèces', 'card' => 'Carte', 'app' => 'Application'] as $val => $label)
              <option value="{{ $val }}" {{ old('paiement') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
          @error('paiement')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Paiement effectué -->
        <div class="flex items-center">
          <input type="checkbox" name="paiement_ok" id="paiement_ok"
                 class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                 {{ old('paiement_ok') ? 'checked' : '' }}>
          <label for="paiement_ok" class="ml-2 text-sm text-gray-700">Paiement effectué</label>
        </div>

        <!-- Bouton de soumission -->
        <div>
          <button type="submit"
                  class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded hover:bg-green-700 transition-colors duration-200">
            Enregistrer la sortie
          </button>
        </div>
     

      </form>

    
      <p class="text-red-600 font-semibold mt-4">
        Toutes les sorties ont déjà été enregistrées pour cette plaque.
      </p>
    @endif
  </div>
</div>
</div>
@endsection
