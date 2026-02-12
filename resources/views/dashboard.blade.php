@extends('layouts.app')

@section('title', 'Mes Tickets')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Mes Demandes d'Hébergement</h1>
        <a href="{{ route('tickets.create') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            ✚ Nouvelle Demande
        </a>
    </div>

    <!-- ⭐ NOTIFICATIONS SECTION -->
            @if(Auth::user()->unreadNotificationsCount() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        🔔 Notifications ({{ Auth::user()->unreadNotificationsCount() }})
                    </h3>

                    <div class="space-y-2">
                        @foreach(Auth::user()->recentNotifications() as $notification)
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-blue-900">{{ $notification->title }}</p>
                                    <p class="text-blue-800 text-sm">{{ $notification->message }}</p>
                                    <p class="text-blue-600 text-xs mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>

            @endforeach
        </div>
            @endif
    <!-- END NOTIFICATIONS SECTION -->

    @if($tickets->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">📝</div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun ticket</h3>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore créé de demande d'hébergement</p>
            <a href="{{ route('tickets.create') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Créer ma première demande
            </a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($tickets as $ticket)
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <h3 class="text-xl font-bold text-gray-800">
                                Ticket #{{ $ticket->id }}
                            </h3>
                            @if($ticket->statut === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    ⏳ En attente
                                </span>
                            @elseif($ticket->statut === 'validated')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    ✓ Validé
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    ✕ Annulé
                                </span>
                            @endif
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Pack</p>
                                <p class="font-bold text-blue-600">{{ $ticket->hosting->nom }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Prix</p>
                                <p class="font-bold">{{ $ticket->hosting->prix }} DA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Durée</p>
                                <p class="font-bold">{{ $ticket->hosting->duree }}</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Nom:</span>
                                <span class="font-medium">{{ $ticket->nom_complet }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Téléphone:</span>
                                <span class="font-medium">{{ $ticket->telephone }}</span>
                            </div>
                            @if($ticket->societe)
                            <div>
                                <span class="text-gray-600">Société:</span>
                                <span class="font-medium">{{ $ticket->societe }}</span>
                            </div>
                            @endif
                            <div>
                                <span class="text-gray-600">Créé le:</span>
                                <span class="font-medium">{{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 ml-6">
                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center text-sm">
                            👁️ Voir
                        </a>
                        
                        @if($ticket->statut !== 'canceled')
                        <a href="{{ route('tickets.edit', $ticket->id) }}" 
                           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-center text-sm">
                            ✏️ Modifier
                        </a>
                        @endif

                        <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">
                                🗑️ Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
