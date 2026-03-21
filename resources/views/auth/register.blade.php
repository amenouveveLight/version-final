@extends('layouts.app')

@section('content')
<!-- Conteneur principal : Padding-top réduit sur mobile (pt-20) et large sur PC (md:pt-32) -->
<div class="min-h-screen  pt-20 pb-10 md:pt-32 px-4">
    
    <div class="flex justify-center items-center">
        <!-- Card du formulaire : max-w-md sur PC, occupe presque tout l'écran sur mobile -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            
            <!-- Header du Formulaire -->
            <div class="flex justify-between items-center p-5 md:p-6 border-b bg-white">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Créer un compte</h3>
                    <p class="text-xs text-gray-500 mt-1">Rejoignez la gestion de parking AK</p>
                </div>
                <button class="close-modal text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 md:p-8">
                
                <!-- 🚨 AFFICHAGE DES ERREURS -->
                @if ($errors->any())
                    <div class="mb-5 bg-red-50 p-4 rounded-xl border border-red-100">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                ❌
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-700 list-disc pl-2 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Prénom et Nom : Côte à côte sur Tablette/PC (sm:grid-cols-2) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="firstname" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Prénom</label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-gray-900" 
                                placeholder="Kodzo">
                        </div>
                        <div class="flex flex-col">
                            <label for="lastname" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nom</label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-gray-900" 
                                placeholder="Yaya">
                        </div>
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="email" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email professionnel</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-gray-900" 
                            placeholder="votre@email.com">
                    </div>

                    <div class="flex flex-col">
                        <label for="role" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Type de compte</label>
                        <div class="relative">
                            <select id="role" name="role" required 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none appearance-none bg-white text-gray-900">
                                <option value="admin">Administrateur</option>
                                <option value="gerant">Gérant</option>
                                <option value="agent">Agent de parking</option>
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                                🔽
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="password" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Mot de passe</label>
                        <input type="password" id="password" name="password" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-gray-900" 
                            placeholder="••••••••">
                    </div>
                    
                    <div class="flex flex-col">
                        <label for="confirm" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Confirmation</label>
                        <input type="password" id="confirm" name="password_confirmation" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition text-gray-900" 
                            placeholder="••••••••">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-bold text-lg shadow-lg shadow-green-200 transition-all active:scale-95">
                            Créer mon compte
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center border-t pt-5">
                    <p class="text-sm text-gray-600">
                        Déjà inscrit ? 
                        <a href="{{ route('login') }}" class="font-bold text-green-600 hover:text-green-700 underline underline-offset-4">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Optionnel : petite animation d'entrée */
    .modal-content {
        animation: slideUp 0.4s ease-out;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection