@extends('layouts.app')

@section('title', 'Modifier le Ticket')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Modifier le Ticket #{{ $ticket->id }}</h2>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            ← Retour
        </a>
    </div>

    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
        @csrf
        @method('PUT')

        <!-- Nom complet -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom complet *</label>
            <input type="text" name="nom_complet" value="{{ old('nom_complet', $ticket->nom_complet) }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('nom_complet')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email (pré-rempli, non modifiable) -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" value="{{ $ticket->user->email }}" 
                   class="w-full px-4 py-2 border rounded bg-gray-100" disabled>
        </div>

        <!-- Téléphone -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Numéro de téléphone *</label>
            <input type="tel" name="telephone" value="{{ old('telephone', $ticket->telephone) }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('telephone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Adresse -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Adresse *</label>
            <textarea name="adresse" rows="3" 
                      class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>{{ old('adresse', $ticket->adresse) }}</textarea>
            @error('adresse')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nom de la société -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom de la société (facultatif)</label>
            <input type="text" name="societe" value="{{ old('societe', $ticket->societe) }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
            @error('societe')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Choix de l'hébergement -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Choix de l'hébergement *</label>
            <select name="hosting_id" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                @foreach($hostings as $hosting)
                    <option value="{{ $hosting->id }}" 
                            {{ old('hosting_id', $ticket->hosting_id) == $hosting->id ? 'selected' : '' }}>
                        {{ $hosting->nom }} - {{ $hosting->prix }} DA - {{ $hosting->duree }}
                    </option>
                @endforeach
            </select>
            @error('hosting_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Statut -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Statut *</label>
            <select name="statut" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                <option value="pending" {{ old('statut', $ticket->statut) == 'pending' ? 'selected' : '' }}>
                    En attente
                </option>
                <option value="validated" {{ old('statut', $ticket->statut) == 'validated' ? 'selected' : '' }}>
                    Validé
                </option>
                <option value="canceled" {{ old('statut', $ticket->statut) == 'canceled' ? 'selected' : '' }}>
                    Annulé
                </option>
            </select>
            @error('statut')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex space-x-4">
            <a href="{{ route('dashboard') }}" 
               class="flex-1 bg-gray-500 text-white text-center py-3 rounded hover:bg-gray-600">
                Annuler
            </a>
            <button type="submit" 
                    class="flex-1 bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
                💾 Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection