@extends('layouts.app')

@section('title', 'Formulaire de demande')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Formulaire de demande d'hébergement</h2>

    <form method="POST" action="{{ route('tickets.store') }}">
        @csrf

        <!-- Nom complet -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom complet *</label>
            <input type="text" name="nom_complet" value="{{ old('nom_complet') }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('nom_complet')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email (pré-rempli) -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" value="{{ Auth::user()->email }}" 
                   class="w-full px-4 py-2 border rounded bg-gray-100" disabled>
        </div>

        <!-- Téléphone -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Numéro de téléphone *</label>
            <input type="tel" name="telephone" value="{{ old('telephone') }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            @error('telephone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Adresse -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Adresse *</label>
            <textarea name="adresse" rows="3" 
                      class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>{{ old('adresse') }}</textarea>
            @error('adresse')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nom de la société (facultatif) -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom de la société (facultatif)</label>
            <input type="text" name="societe" value="{{ old('societe') }}" 
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500">
            @error('societe')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Choix de l'hébergement -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Choix de l'hébergement *</label>
            <select name="hosting_id" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-blue-500" required>
                <option value="">Sélectionnez un pack</option>
                @foreach($hostings as $hosting)
                    <option value="{{ $hosting->id }}" {{ old('hosting_id') == $hosting->id ? 'selected' : '' }}>
                        {{ $hosting->nom }} - {{ $hosting->prix }} DA - {{ $hosting->duree }}
                    </option>
                @endforeach
            </select>
            @error('hosting_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex space-x-4">
            <a href="{{ route('home') }}" class="flex-1 bg-gray-500 text-white text-center py-3 rounded hover:bg-gray-600">
                Refuser
            </a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
                Valider
            </button>
        </div>
    </form>
</div>
@endsection