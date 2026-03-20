@extends('layouts.app')

      @section('content')

<div class="pt-28">
    <!-- Ici ton contenu principal -->

   <!-- Hero Welcome Section -->
    <section class="hero-pattern bg-green-700 text-white py-20 ">
    <div class="max-w-7xl mx-auto px-6 md:px-10 grid md:grid-cols-2 gap-12 items-center"> 
        <!-- Left: Welcome Content -->
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight drop-shadow-lg">
                Bienvenue sur <span class="text-green-200"> solution digital</span>
            </h1>
            <p class="mt-5 text-lg md:text-xl text-green-100 leading-relaxed max-w-xl">
      « Gérez le parking de votre marché en toute simplicité. »
Une solution claire et efficace pour organiser, sécuriser et rentabiliser les places de stationnement au service des commerçants et des clients..</p>

            <!-- Social Proof -->
            <div class="mt-10 flex items-center mb-20">
                <div class="flex -space-x-3 mr-4">
                    <img class="h-10 w-10 rounded-full border-2 border-white" src="https://api.dicebear.com/7.x/personas/svg?seed=Alpha" alt="User 1">
                    <img class="h-10 w-10 rounded-full border-2 border-white" src="https://api.dicebear.com/7.x/personas/svg?seed=Beta" alt="User 2">
                    <img class="h-10 w-10 rounded-full border-2 border-white" src="https://api.dicebear.com/7.x/personas/svg?seed=Gamma" alt="User 3">
                </div>
                <p class="text-green-100 text-sm sm:text-base">
                    Déjà adopté par <span class="font-bold text-white">Plus de 50 clients nous font confiance</span>
                </p>
            </div>
        </div>

        <!-- Right: SVG Illustration -->
        <div class="hidden md:block mb-20">
            <svg class="w-full max-w-md mx-auto" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
                <rect x="50" y="50" width="300" height="200" fill="#e5e7eb" rx="6" />
                <g fill="#d1d5db">
                    <rect x="70" y="70" width="80" height="40" rx="3" />
                    <rect x="160" y="70" width="80" height="40" rx="3" />
                    <rect x="250" y="70" width="80" height="40" rx="3" />
                    <rect x="70" y="130" width="80" height="40" rx="3" />
                    <rect x="250" y="130" width="80" height="40" rx="3" />
                    <rect x="70" y="190" width="80" height="40" rx="3" />
                    <rect x="160" y="190" width="80" height="40" rx="3" />
                </g>
                <rect x="160" y="130" width="80" height="40" fill="#22c55e" rx="3" />
                <rect x="250" y="190" width="80" height="40" fill="#22c55e" rx="3" />
                <rect x="85" y="75" width="50" height="30" fill="#60a5fa" rx="5" />
                <rect x="175" y="75" width="50" height="30" fill="#f87171" rx="5" />
                <rect x="85" y="195" width="50" height="30" fill="#34d399" rx="5" />
                <circle cx="30" cy="30" r="20" fill="#22c55e" />
                <text x="30" y="35" font-size="20" text-anchor="middle" fill="white" font-weight="bold">P</text>
            </svg>
        </div>
    </div>
</section>
</div>
@endsection('content')