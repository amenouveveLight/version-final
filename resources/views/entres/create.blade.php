@extends('layouts.app')

      @section('content')


<div class="pt-28">
    <!-- Ici ton contenu principal -->

 <main class="pt-2">
    <div class="max-w-3xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Enregistrement d'une entrée</h2>

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

        <form id="entry-form" method="POST" action="{{ route('entres.store') }}" class="space-y-5">
          @csrf
          <!-- Plaque -->
          <div>
            <label for="plaque" class="block text-sm font-medium text-gray-700 mb-1">Plaque d'immatriculation</label>
            <input type="text" id="plaque" name="plaque" value="{{ old('plaque') }}"
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
              <option value="" disabled selected>Sélectionner un type</option>
              <option value="motorcycle">Moto</option>
              <option value="car">Voiture</option>
              <option value="tricycle">Tricycle</option>
              <option value="nyonyovi">Nyonyovi</option>
              <option value="minibus">Minibus</option>
              <option value="bus">Bus</option>
              <option value="truck">Camion</option>
            </select>
          </div>

          <!-- Nom -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du propriétaire</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
              placeholder="Nom complet">
          </div>

          <!-- Téléphone -->
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 text-gray-700"
              placeholder="Ex: 90123456">
          </div>
          <!-- Bouton -->
          <button type="submit" id="submit-btn"
            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-primary-700 transition disabled:opacity-50 ">
            <span id="btn-text">Enregistrer l'entrée</span>
          </button>
        </form>
          @if(session('ticket_url'))
    <script>
        window.open("{{ session('ticket_url') }}", '_blank');
    </script>
@endif
      </div>
    </div>
  </main>
  </div>
  </div>

  <!-- Vérification AJAX -->
  <script>
    document.getElementById('plaque').addEventListener('blur', function () {
      const plaque = this.value;
      const type = document.getElementById('type').value;
      if (plaque && type) {
        fetch(`/check-plaque?plaque=${plaque}&type=${type}`)
          .then(res => res.json())
          .then(data => {
            const status = document.getElementById('plaque-status');
            const btn = document.getElementById('submit-btn');
            if (data.exists) {
              status.classList.remove('hidden');
              btn.disabled = true;
            } else {
              status.classList.add('hidden');
              btn.disabled = false;
            }
          });
      }
    });
  

  </script>
  @endsection('content')

