@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-green-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 pt-28">
    <div class="sm:mx-auto sm:w-full sm:max-w-md md:max-w-2xl">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Créer un compte professionnel
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 font-medium">
            Accès réservé aux administrateurs, gérants et agents.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md md:max-w-2xl">
        <div class="bg-white py-8 px-4 shadow-xl border border-gray-100 sm:rounded-lg sm:px-10 mx-4 sm:mx-0">
            
            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-md border-l-4 border-red-500">
                    <ul class="list-disc pl-5 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Ligne Prénom et Nom (Grid 2 colonnes sur Tablette/PC) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstname" class="block text-sm font-semibold text-gray-700">Prénom</label>
                        <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Kodzo">
                    </div>

                    <div>
                        <label for="lastname" class="block text-sm font-semibold text-gray-700">Nom</label>
                        <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="YAYA">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Adresse Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                        placeholder="votre@email.com">
                </div>

                <!-- Sélection du Rôle (Basé sur ton contrôleur) -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700">Rôle / Fonction</label>
                    <select id="role" name="role" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm bg-white">
                        <option value="" disabled selected>Sélectionnez un rôle</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="gerant" {{ old('role') == 'gerant' ? 'selected' : '' }}>Gérant</option>
                        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent de parking</option>
                    </select>
                </div>

                <!-- Ligne Mots de passe (Grid 2 colonnes sur Tablette/PC) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">Mot de passe</label>
                        <input type="password" id="password" name="password" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirmer</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required 
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700 font-medium">
                            J'accepte les <a href="#" class="text-green-600 hover:underline">conditions d'utilisation</a>
                        </label>
                    </div>
                </div>

                <!-- Bouton Créer Compte -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                        CRÉER LE COMPTE
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Déjà inscrit ? 
                    <a href="{{ route('login') }}" class="font-bold text-green-600 hover:text-green-500">
                        Se connecter ici
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection