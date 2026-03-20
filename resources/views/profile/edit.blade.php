@extends('layouts.app')

@section('content')
<div class="pt-28">
    <!-- Ici ton contenu principal -->
<div class="mt-5">
    
  <!-- Dashboard Overview Section -->
<div id="dashboard" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 -mt-16 relative z-10">
<section class="mt-1  min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 relative z-10 space-y-8">

            {{-- Informations personnelles --}}
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Informations personnelles</h2>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="name"
                               value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-gray-600"
                               placeholder="Nom">
                        <input type="email" name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-gray-600"
                               placeholder="Email">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sécurité du compte --}}
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Sécurité du compte</h2>
                <form method="POST" action="{{ route('password.update') }}" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="password" name="current_password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-gray-600"
                           placeholder="Mot de passe actuel">
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-gray-600"
                           placeholder="Nouveau mot de passe">
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-gray-600"
                           placeholder="Confirmation">
                    <div class="flex justify-end">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                            Modifier mot de passe
                        </button>
                    </div>
                </form>
            </div>

            {{-- Suppression du compte --}}
            <div class="space-y-2">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Suppression du compte</h2>
                <form method="POST" action="{{ route('profile.destroy') }}"
                      onsubmit="return confirm('Supprimer définitivement votre compte ?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full border border-red-600 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-500 hover:text-white transition">
                      Supprimer mon compte
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
</div>
</div>
@endsection
