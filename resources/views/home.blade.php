@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue chez ICOSNET</h1>
    <p class="text-xl text-gray-600">Solutions d'hébergement web professionnelles</p>
</div>

<div class="grid md:grid-cols-3 gap-8">
    @foreach($hostings as $hosting)
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
        <h3 class="text-2xl font-bold text-blue-600 mb-4">{{ $hosting->nom }}</h3>
        <div class="text-3xl font-bold text-gray-800 mb-2">{{ $hosting->prix }} DA</div>
        <div class="text-gray-600 mb-6">Durée : {{ $hosting->duree }}</div>
        
        <ul class="text-gray-700 mb-6 space-y-2">
            <li>✓ Support 24/7</li>
            <li>✓ SSL Gratuit</li>
            <li>✓ Sauvegarde quotidienne</li>
            <li>✓ Bande passante illimitée</li>
        </ul>

        @auth
            <a href="{{ route('tickets.create') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded hover:bg-blue-700">
                Choisir ce pack
            </a>
        @else
            <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded hover:bg-blue-700">
                S'inscrire
            </a>
        @endauth
    </div>
    @endforeach
</div>

<div class="mt-12 bg-blue-50 rounded-lg p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Pourquoi choisir ICOSNET ?</h2>
    <div class="grid md:grid-cols-3 gap-6">
        <div>
            <h3 class="font-bold text-lg mb-2">🚀 Performance</h3>
            <p class="text-gray-600">Serveurs ultra-rapides pour votre site web</p>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-2">🔒 Sécurité</h3>
            <p class="text-gray-600">Protection maximale de vos données</p>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-2">💬 Support</h3>
            <p class="text-gray-600">Équipe disponible 24h/24 et 7j/7</p>
        </div>
    </div>
</div>
@endsection
