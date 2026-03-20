@extends('layouts.app')

@section('content')

<div class="pt-28 min-h-screen ">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    Gestion des utilisateurs
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Créer un nouvel utilisateur
                </p>
            </div>

            <!-- Success -->
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700 flex justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('utilisateurs.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Infos personnelles -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Informations personnelles
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Prénom *
                            </label>
                            <input
                                type="text"
                                name="firstname"
                                required
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700"
                            >
                            @error('firstname')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Nom *
                            </label>
                            <input
                                type="text"
                                name="lastname"
                                required
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700"
                            >
                            @error('lastname')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Connexion -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Informations de connexion
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Email *
                            </label>
                            <input
                                type="email"
                                name="email"
                                required
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700"
                            >
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Mot de passe *
                            </label>
                            <input
                                type="password"
                                name="password"
                                required
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                                       focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700"
                            >
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Rôle -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Rôle
                    </h2>

                    <select
                        name="role"
                        required
                        class="w-full max-w-md rounded-lg border border-gray-300 px-3 py-2
                               focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-700"
                    >
                        <option value="">— Choisir un rôle —</option>
                        <option value="admin">Administrateur</option>
                        <option value="agent">Agent</option>
                        <option value="user">Gérant</option>
                    </select>

                    @error('role')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a
                        href="{{ route('utilisateurs') }}"
                        class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                    >
                        Créer l’utilisateur
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
