@extends('layouts.app')

@section('title', 'Détails du Ticket')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Ticket #{{ $ticket->id }}</h2>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            ← Retour au dashboard
        </a>
    </div>

    <div class="text-center mb-8">
        @if($ticket->statut === 'pending')
            <div class="inline-block bg-yellow-100 text-yellow-800 px-6 py-3 rounded-full text-lg font-bold mb-4">
                ⏳ En attente
            </div>
        @elseif($ticket->statut === 'validated')
            <div class="inline-block bg-green-100 text-green-800 px-6 py-3 rounded-full text-lg font-bold mb-4">
                ✓ Validé
            </div>
        @else
            <div class="inline-block bg-red-100 text-red-800 px-6 py-3 rounded-full text-lg font-bold mb-4">
                ✕ Annulé
            </div>
        @endif
    </div>

    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 font-semibold">Numéro du ticket</p>
                <p class="text-2xl font-bold text-blue-600">#{{ $ticket->id }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Date de création</p>
                <p class="text-lg font-bold">{{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-4 mb-6">
        <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Informations du pack</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Pack choisi</p>
                <p class="font-bold text-lg">{{ $ticket->hosting->nom }}</p>
            </div>
            <div>
                <p class="text-gray-600">Prix</p>
                <p class="font-bold text-lg text-blue-600">{{ $ticket->hosting->prix }} DA</p>
            </div>
            <div>
                <p class="text-gray-600">Durée</p>
                <p class="font-bold">{{ $ticket->hosting->duree }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-4 mb-8">
        <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Vos informations</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Nom complet</p>
                <p class="font-bold">{{ $ticket->nom_complet }}</p>
            </div>
            <div>
                <p class="text-gray-600">Email</p>
                <p class="font-bold">{{ $ticket->user->email }}</p>
            </div>
            <div>
                <p class="text-gray-600">Téléphone</p>
                <p class="font-bold">{{ $ticket->telephone }}</p>
            </div>
            @if($ticket->societe)
            <div>
                <p class="text-gray-600">Société</p>
                <p class="font-bold">{{ $ticket->societe }}</p>
            </div>
            @endif
            <div class="col-span-2">
                <p class="text-gray-600">Adresse</p>
                <p class="font-bold">{{ $ticket->adresse }}</p>
            </div>
        </div>
    </div>

    @if($ticket->statut === 'validated')
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
        <p class="text-blue-800">
            <strong>✓ Validé :</strong> Notre équipe va traiter votre demande dans les meilleurs délais.
        </p>
    </div>
    @elseif($ticket->statut === 'pending')
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
        <p class="text-yellow-800">
            <strong>⏳ En attente :</strong> Votre demande est en cours de traitement.
        </p>
    </div>
    @endif

    <div class="flex space-x-4">
        @if($ticket->statut !== 'canceled')
        <a href="{{ route('tickets.edit', $ticket->id) }}" 
           class="flex-1 bg-green-600 text-white text-center py-3 rounded hover:bg-green-700">
            ✏️ Modifier
        </a>
        @endif

        <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" class="flex-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-500 text-white py-3 rounded hover:bg-red-600"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')">
                🗑️ Supprimer
            </button>
        </form>

        <a href="{{ route('dashboard') }}" 
           class="flex-1 bg-blue-600 text-white text-center py-3 rounded hover:bg-blue-700">
            ← Retour
        </a>
    </div>
</div>
@endsection