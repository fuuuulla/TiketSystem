@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 rounded-2xl overflow-hidden shadow-2xl mb-16 mt-4">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="relative px-8 py-20 md:py-28 text-center sm:px-12 lg:px-16">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight mb-6">
            L'hébergement web<br/>
            <span class="text-blue-200">réinventé</span> pour vous
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-xl text-blue-100 sm:mt-5 mb-10">
            Des performances inégalées, une sécurité maximale, et un support expert disponible 24/7. Propulsez votre entreprise avec ICOSNET.
        </p>
        <div class="flex justify-center gap-4 flex-col sm:flex-row">
            @auth
                <a href="{{ route('tickets.create') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-blue-700 bg-white hover:bg-gray-50 hover:scale-105 transition-all duration-300 shadow-xl">
                    Commandez maintenant
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-blue-700 bg-white hover:bg-gray-50 hover:-translate-y-1 transition-all duration-300 shadow-xl">
                    Commencer gratuitement
                </a>
                <a href="#features" class="inline-flex justify-center items-center px-8 py-4 border-2 border-white/20 text-lg font-bold rounded-xl text-white hover:bg-white/10 transition-all duration-300">
                    Découvrir nos offres
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Pricing Section -->
<div id="features" class="mb-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 inline-block">Nos Packs d'Hébergement</h2>
        <p class="mt-4 text-lg text-gray-500">Choisissez la solution parfaitement adaptée à vos besoins</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        @foreach($hostings as $index => $hosting)
        <div class="relative bg-white rounded-2xl border border-gray-100 p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col group {{ $index === 1 ? 'ring-2 ring-blue-500 scale-105 md:scale-105 z-10' : '' }}">
            
            @if($index === 1)
                <div class="absolute top-0 inset-x-0 flex justify-center -mt-4">
                    <span class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-sm">
                        Le plus populaire
                    </span>
                </div>
            @endif

            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $hosting->nom }}</h3>
            
            <div class="mt-4 flex items-baseline text-4xl font-extrabold text-gray-900">
                {{ number_format($hosting->prix, 0, ',', ' ') }}
                <span class="ml-1 text-xl font-medium text-gray-500">DA</span>
            </div>
            <p class="mt-1 text-sm text-gray-500 uppercase font-semibold tracking-wide">/ {{ $hosting->duree }}</p>

            <ul class="mt-8 space-y-4 flex-1">
                <li class="flex items-start">
                    <svg class="flex-shrink-0 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="ml-3 text-gray-600">Support <span class="font-semibold text-gray-900">24/7 expert</span></span>
                </li>
                <li class="flex items-start">
                    <svg class="flex-shrink-0 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="ml-3 text-gray-600">Certificat <span class="font-semibold text-gray-900">SSL Inclus</span></span>
                </li>
                <li class="flex items-start">
                    <svg class="flex-shrink-0 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="ml-3 text-gray-600">Sauvegarde <span class="font-semibold text-gray-900">quotidienne</span></span>
                </li>
                <li class="flex items-start">
                    <svg class="flex-shrink-0 h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="ml-3 text-gray-600">Bande passante <span class="font-semibold text-gray-900">illimitée</span></span>
                </li>
            </ul>

            <div class="mt-8">
                @auth
                    <a href="{{ route('tickets.create') }}" class="block w-full {{ $index === 1 ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-xl' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }} text-center py-3 px-4 rounded-lg font-bold transition-all duration-200">
                        Choisir ce pack
                    </a>
                @else
                    <a href="{{ route('register') }}" class="block w-full {{ $index === 1 ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-xl' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }} text-center py-3 px-4 rounded-lg font-bold transition-all duration-200">
                        Créer un compte
                    </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Features Section -->
<div class="bg-white rounded-3xl p-8 md:p-16 shadow-xl border border-gray-100 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    
    <div class="relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Pourquoi choisir ICOSNET ?</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">L'excellence au service de vos projets digitaux</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-10">
            <!-- Feature 1 -->
            <div class="text-center group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-100 text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Performance Maximale</h3>
                <p class="text-gray-500 leading-relaxed">Infrastructure cloud de dernière génération et disques NVMe garantissant des temps de chargement éclair pour tous vos visiteurs.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-indigo-100 text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité Blindée</h3>
                <p class="text-gray-500 leading-relaxed">Protection anti-DDoS proactive, pare-feu applicatif (WAF) et certificats SSL Let's Encrypt offerts pour sécuriser toutes vos données.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-100 text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Support Premium 24/7</h3>
                <p class="text-gray-500 leading-relaxed">Notre équipe d'ingénieurs réseaux passionnés est disponible à tout moment via ticket sécurisé pour résoudre vos problèmes techniques.</p>
            </div>
        </div>
    </div>
</div>
@endsection
