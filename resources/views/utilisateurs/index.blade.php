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
      

            <!-- Users Section -->
            <section id="users-section" class="px-4 sm:px-0 ">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h1>
                    <p class="mt-1 text-sm text-gray-500">Gérer les utilisateurs du système</p>
                </div>
                
   <!-- Users Controls -->
<div class="bg-white rounded-lg shadow mb-6">
  <div class="p-6">
 <form method="GET" action="{{ route('utilisateurs') }}"
      class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4"
      id="searchForm">

  <!-- Recherche -->
  <div class="flex-1 min-w-0">
  <div class="relative group">
    
    <!-- Icon -->
    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors">
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
    </div>

    <!-- Input -->
    <input
      type="text"
      name="search"
      value="{{ request('search') }}"
      placeholder="Rechercher un utilisateur..."
      oninput="document.getElementById('searchForm').submit()"
      class="w-full pl-10 pr-4 py-2.8 rounded-xl border border-green-300
             bg-white text-gray-800 placeholder-gray-400
             focus:ring-2 focus:ring-primary-500 focus:border-primary-500
             transition-all duration-150 shadow-sm"
    >
  </div>
</div>


  <!-- Filtre rôle -->
  <div class="flex items-center space-x-3">
    <div class="relative">
      <select
        name="role"
        class="appearance-none bg-white border border-gray-600 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 text-gray-700"
        onchange="document.getElementById('searchForm').submit()"
      >
        <option value="" {{ request('role') == '' ? 'selected' : '' }}>Tous les rôles</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
        <option value="agent" {{ request('role') == 'agent' ? 'selected' : '' }}>Agent</option>
        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Gerant</option>
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>
    </div>
  </div>

  <!-- Bouton Ajouter -->
  <div>
  <a href="{{ route('utilisateurs.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow">
      <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
      </svg>
      Ajouter
      </a>
    </button>
  </div>
</form>

  </div>
</div>

<!-- Modale Formulaire d'ajout -->
<div id="userFormContainer" class=" fixed inset-0 bg-gray-800 bg-opacity-50 {{ $errors->any() ? 'flex' : 'hidden' }} items-center justify-center z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">

    <!-- Bouton fermer -->
    <button onclick="closeUserForm()" class="absolute top-2 right-2 text-gray-600 hover:text-black">✕</button>

    <!-- Titre -->
    <h2 id="formTitle" class="text-lg font-bold mb-4">
      {{ old('role') ? 'Créer un utilisateur : ' . ucfirst(old('role')) : 'Créer un utilisateur' }}
    </h2>

    <!-- Formulaire -->
    <form action="{{ route('utilisateurs.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block text-gray-700">Prénom</label>
        <input type="text" name="firstname" value="{{ old('firstname') }}" class="w-full border rounded px-3 py-2 green-600 text-gray-700" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Nom</label>
        <input type="text" name="lastname" value="{{ old('lastname') }}" class="w-full border rounded px-3 py-2 text-gray-700" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 text-gray-700" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Mot de passe</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2  text-gray-700" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Rôle</label>
        <select name="role" id="userRole" class="w-full border-900 rounded px-3 py-2 text-gray-700" required>
          <option value="">-- Choisir un rôle --</option>
          <option value="admin" >Administrateur</option>
          <option value="agent" >Agent</option>
          <option value="user" >Gerant</option>
        </select>
      </div>

      <div class="text-right">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Créer</button>
      </div>
    </form>
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Succès !</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span onclick="this.parentElement.remove();" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            ✕
        </span>
    </div>
@endif
  </div>
</div>

            <!-- Users Table -->
                      <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 admin-table">
        <thead>
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière connexion</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                {{-- Ici tu peux mettre une image utilisateur si tu en as --}}
                                <img class="h-10 w-10 rounded-full" src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->firstname . ' ' . $user->lastname) }}" alt="{{ $user->firstname }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->firstname }} {{ $user->lastname }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $roleColors = [
                                'admin' => 'bg-primary-100 text-primary-800',
                                'agent' => 'bg-blue-100 text-blue-800',
                                'user'  => 'bg-gray-100 text-gray-800',
                            ];
                            $roleLabels = [
                                'admin' => 'Administrateur',
                                'agent' => 'Agent',
                                'user'  => 'Utilisateur',
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->status)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Inactif</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('utilisateurs.edit', $user->id) }}" class="text-primary-600 hover:text-primary-900 mr-3">Modifier</a>

                        <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
          <div class="flex items-center justify-between mt-6">
    <div class="flex-1 flex justify-between sm:hidden">
        @if ($users->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-white cursor-not-allowed">Précédent</span>
        @else
            <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Précédent</a>
        @endif

        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Suivant</a>
        @else
            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-white cursor-not-allowed">Suivant</span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Affichage de <span class="font-medium">{{ $users->firstItem() }}</span> à <span class="font-medium">{{ $users->lastItem() }}</span> sur <span class="font-medium">{{ $users->total() }}</span> utilisateurs
            </p>
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

            </section>

@endsection