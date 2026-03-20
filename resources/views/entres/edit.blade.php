@extends('layouts.app')

      @section('content')


<div class="pt-28">
    <!-- Ici ton contenu principal -->

 <main class="pt-2">
    <div class="max-w-3xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Modifier une entrée</h2>

        <!-- Messages -->
        @if ($errors->any())
          <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif
        @if (session('success'))
          <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">{{ session('success') }}</div>
        @endif
<form id="entry-form" method="POST" action="{{ route('entres.update', $entree->id) }}" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- Plaque -->
    <div>
        <label for="plaque" class="block text-sm font-medium text-gray-700 mb-1">Plaque d'immatriculation</label>
        <input type="text" id="plaque" name="plaque" value="{{ old('plaque', $entree->plaque) }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
            placeholder="Ex: TG-1234-AB" required>
        <p id="plaque-status" class="text-sm mt-1 text-red-500 hidden">Ce véhicule est déjà présent dans le parking.</p>
    </div>

    <!-- Type -->
    <div>
        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type de véhicule</label>
        <select id="type" name="type"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
            required>
            <option value="" disabled {{ old('type', $entree->type) ? '' : 'selected' }}>Sélectionner un type</option>
            <option value="motorcycle" {{ old('type', $entree->type) == 'motorcycle' ? 'selected' : '' }}>Moto</option>
            <option value="car" {{ old('type', $entree->type) == 'car' ? 'selected' : '' }}>Voiture</option>
            <option value="tricycle" {{ old('type', $entree->type) == 'tricycle' ? 'selected' : '' }}>Tricycle</option>
            <option value="nyonyovi" {{ old('type', $entree->type) == 'nyonyovi' ? 'selected' : '' }}>Nyonyovi</option>
            <option value="minibus" {{ old('type', $entree->type) == 'minibus' ? 'selected' : '' }}>Minibus</option>
            <option value="bus" {{ old('type', $entree->type) == 'bus' ? 'selected' : '' }}>Bus</option>
            <option value="truck" {{ old('type', $entree->type) == 'truck' ? 'selected' : '' }}>Camion</option>
        </select>
    </div>

    <!-- Nom -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du propriétaire</label>
        <input type="text" id="name" name="name" value="{{ old('name', $entree->name) }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
            placeholder="Nom complet">
    </div>

    <!-- Téléphone -->
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
        <input type="tel" id="phone" name="phone" value="{{ old('phone', $entree->phone) }}"
            pattern="[0-9]{8}" title="Entrez un numéro à 8 chiffres"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
            placeholder="Ex: 90123456">
    </div>

    <!-- Bouton -->
    <button type="submit" id="submit-btn"
        class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition disabled:opacity-50">
        <span id="btn-text">Enregistrer l'entrée</span>
    </button>
</form>

<script>
document.getElementById('plaque').addEventListener('blur', checkPlaque);
document.getElementById('type').addEventListener('change', checkPlaque);

function checkPlaque() {
    const plaque = document.getElementById('plaque').value;
    const type = document.getElementById('type').value;
    const status = document.getElementById('plaque-status');
    const btn = document.getElementById('submit-btn');

    if(plaque && type) {
        fetch(`/check-plaque?plaque=${plaque}&type=${type}`)
            .then(res => res.json())
            .then(data => {
                if(data.exists) {
                    status.classList.remove('hidden');
                    btn.disabled = true;
                } else {
                    status.classList.add('hidden');
                    btn.disabled = false;
                }
            });
    }
}
</script>
