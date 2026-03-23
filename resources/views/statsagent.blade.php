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
    <!-- Settings Section -->
        
@php
    // Valeurs par défaut si les variables ne sont pas définies
     $agentsData = $agentsData ?? [];
    $date = $date ?? now()->format('Y-m-d');
    $periode = $periode ?? 'jour';
@endphp

            <!-- Settings Section -->
          <!-- Settings Section -->
            <section id="settings-section" class="px-4 sm:px-0 hidden">
                <div class="mb-6">
              
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-4">Statistiques par agent</h1>

    <div class="mb-4">
        <form method="GET" class="flex gap-2">
            <input type="date" name="date" value="{{ $date }}" class="border p-1 rounded text-gray-600">
            <select name="periode" class="border-green-900 p-1 rounded text-gray-600">
                <option value="jour" @if($periode=='jour') selected @endif>Jour</option>
                <option value="semaine" @if($periode=='semaine') selected @endif>Semaine</option>
                <option value="mois" @if($periode=='mois') selected @endif>Mois</option>
                <option value="année" @if($periode=='année') selected @endif>Année</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Filtrer</button>
        </form>
    </div>
    @php
    $agentsData = $agentsData ?? [];
    $date = $date ?? now()->format('Y-m-d');
    $periode = $periode ?? 'jour';
@endphp


   <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
      <thead class="bg-gray-50">
        <tr>
          <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Agent</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Entrées</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Sorties</th>
          <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Montant Total</th>
       
        </tr>
      </thead>
        <tbody>
            @foreach($agentsData as $data)
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $data['agent'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $data['total_entrees'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $data['total_sorties'] }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ number_format($data['montant_total'], 2) }} FCFA
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>

    <!-- VERSION MOBILE -->
    
</div>

            </section>
        </div>
    </div>
    </div>
    </div>
               </body>
</html>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Navigation functions
            function showSection(sectionId) {
                // Hide all sections
                document.querySelectorAll('section').forEach(section => {
                    section.classList.add('hidden');
                });
                
                // Show the selected section
                document.getElementById(sectionId + '-section').classList.remove('hidden');
                
                // Update desktop nav active state
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active', 'text-primary-600', 'border-primary-500');
                    link.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                });
                document.getElementById('nav-' + sectionId).classList.add('active', 'text-primary-600', 'border-primary-500');
                document.getElementById('nav-' + sectionId).classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                
                // Update mobile menu active state
                document.querySelectorAll('.mobile-link').forEach(link => {
                    link.classList.remove('bg-primary-50', 'border-primary-500', 'text-primary-700');
                    link.classList.add('border-transparent', 'text-gray-600', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:text-gray-800');
                });
                document.getElementById('mobile-' + sectionId).classList.add('bg-primary-50', 'border-primary-500', 'text-primary-700');
                document.getElementById('mobile-' + sectionId).classList.remove('border-transparent', 'text-gray-600', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:text-gray-800');
                
                // Close mobile menu after selection
                mobileMenu.classList.add('hidden');
            }
            
            // Desktop navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sectionId = this.getAttribute('href').substring(1);
                    showSection(sectionId);
                });
            });
            
            // Mobile navigation
            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sectionId = this.getAttribute('href').substring(1);
                    showSection(sectionId);
                });
            });
            
            // Initialize with dashboard
            showSection('dashboard');
        });
    
(function(){function c()
{var b=a.contentDocument||a.contentWindow.document;
if(b){var d=b.createElement('script')
;d.innerHTML="window.__CF$cv$params={r:'9672df5a615306f3',t:'MTc1Mzg1NzcwOS4wMDAwMDA='}
;var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';
document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}
if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';
    a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);
    if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);
    else{var e=document.onreadystatechange||
        function(){};
        document.onreadystatechange=function(b){e(b);
            'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();
            </script>
  <!-- Scripts -->
<script>
  function openUserForm() {
    const formModal = document.getElementById('userFormContainer');
    formModal.classList.remove('hidden');
    formModal.classList.add('flex');

    document.getElementById('formTitle').textContent = "Créer un utilisateur";
  }

  function closeUserForm() {
    const formModal = document.getElementById('userFormContainer');
    formModal.classList.add('hidden');
    formModal.classList.remove('flex');
  }

document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section[id$="-section"]');

    function showSection(id) {
        // Masquer toutes les sections
        sections.forEach(section => section.classList.add('hidden'));
        // Afficher la section choisie
        document.querySelector(id).classList.remove('hidden');
        // Style des onglets
        links.forEach(link => link.classList.remove('border-primary-500', 'text-primary-600'));
        const activeLink = document.querySelector(`a[href="${id}"]`);
        if (activeLink) {
            activeLink.classList.add('border-primary-500', 'text-primary-600');
        }
        // Sauvegarder l'onglet actif
        localStorage.setItem('activeTab', id);
    }

    // Gestion du clic
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            showSection(this.getAttribute('href'));
        });
    });

    // Charger la dernière section consultée ou la première par défaut
    const activeTab = localStorage.getItem('activeTab') || '#users-section';
    showSection(activeTab);
});
</script>

 
 
@endsection('content')