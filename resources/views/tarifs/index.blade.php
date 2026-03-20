@extends('layouts.app')

      @section('content')


<div class="pt-28">
    <!-- Ici ton contenu principal -->

<body>
    <div class="mt-5">
    
  <!-- Dashboard Overview Section -->
<div id="dashboard" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 -mt-16 relative z-10">
    <div class="min-h-screen bg-gray-50 " >

<section id="pricing-section" class="px-4 sm:px-0 ">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Gestion des tarifs</h1>
    <p class="mt-1 text-sm text-gray-500">Configurer les tarifs journaliers par type de véhicule</p>
  </div>

  <div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6">
      <form method="POST" action="{{ route('tarifs.update') }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">

          

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
              $types = config('vehicle_types');
            @endphp

            @foreach ($types as $key => $label)
              <div>
                <label for="{{ $key }}-price" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">FCFA</span>
                  </div>
                  <input
                    type="number"
                    name="tarifs[{{ $key }}]"
                    id="{{ $key }}-price"
                    class="focus:ring-primary-500 focus:border-green-500 block w-full pl-16 pr-12 sm:text-sm border-gray-300 rounded-md text-gray-700"
                    placeholder="0"
                    value="{{ old('tarifs.' . $key, $tarifs[$key] ?? '') }}"
                    required
                  >
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">/jour</span>
                  </div>
                </div>
                @error('tarifs.' . $key)
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            @endforeach
          </div>

          <div class="flex justify-end pt-6 border-t border-gray-200">
            <button type="reset" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
              Annuler
            </button>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
              Enregistrer
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>
</section>
@endsection