@extends('layouts.app')

@section('title', 'Mes Tickets')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Mes Demandes d'Hébergement</h1>
            <p class="text-gray-500 mt-1">Gérez vos souscriptions et suivez l'état de vos demandes.</p>
        </div>
        <a href="{{ route('tickets.create') }}" 
           class="inline-flex justify-center items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle Demande
        </a>
    </div>

    <!-- ⭐ NOTIFICATIONS SECTION -->
    @if(Auth::user()->unreadNotificationsCount() > 0)
        <div class="bg-blue-50/50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="text-lg font-bold text-gray-900">
                    Notifications Récentes ({{ Auth::user()->unreadNotificationsCount() }})
                </h3>
            </div>

            <div class="space-y-3">
                @foreach(Auth::user()->recentNotifications() as $notification)
                    <div class="bg-white border-l-4 border-blue-500 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow flex justify-between items-start group">
                        <div>
                            <p class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $notification->title }}</p>
                            <p class="text-gray-600 text-sm mt-1">{{ $notification->message }}</p>
                            <div class="flex items-center mt-2 text-xs text-gray-400 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('notifications.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">Voir toutes les notifications →</a>
            </div>
        </div>
    @endif
    <!-- END NOTIFICATIONS SECTION -->

    @if($tickets->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucune Demande</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Vous n'avez pas encore créé de demande d'hébergement. Commencez dès maintenant pour propulser votre entreprise web.</p>
            <a href="{{ route('tickets.create') }}" 
               class="inline-flex justify-center items-center bg-blue-600 text-white px-8 py-3.5 rounded-xl hover:bg-blue-700 text-lg font-bold shadow-md hover:shadow-lg transition-all hover:-translate-y-1">
                Créer ma première demande
            </a>
        </div>
    @else
        <!-- Tickets Grid -->
        <div class="grid gap-6">
            @foreach($tickets as $ticket)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                    
                    <div class="flex-1 w-full">
                        <div class="flex flex-wrap items-center gap-4 mb-5 border-b border-gray-100 pb-4">
                            <h3 class="text-xl font-bold text-gray-900">
                                Demande <span class="text-gray-400">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </h3>
                            
                            @if($ticket->statut === 'pending')
                                <span class="inline-flex items-center rounded-md bg-yellow-50 px-2.5 py-1 text-sm font-semibold text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span>
                                    En attente
                                </span>
                            @elseif($ticket->statut === 'validated')
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                    Validé
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-sm font-semibold text-red-700 ring-1 ring-inset ring-red-600/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                    Annulé
                                </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pack</p>
                                <p class="font-bold text-blue-700 truncate" title="{{ $ticket->hosting->nom }}">{{ $ticket->hosting->nom }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Prix</p>
                                <p class="font-bold text-gray-900">{{ number_format($ticket->hosting->prix, 0, ',', ' ') }} <span class="text-xs text-gray-500">DA</span></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Durée</p>
                                <p class="font-bold text-gray-900">{{ $ticket->hosting->duree }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Date</p>
                                <p class="font-bold text-gray-900">{{ $ticket->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 text-sm bg-blue-50/30 rounded-xl p-4 border border-blue-50/50">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <span class="block text-xs text-gray-500">Bénéficiaire</span>
                                    <span class="font-medium text-gray-900">{{ $ticket->nom_complet }}</span>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <span class="block text-xs text-gray-500">Contact</span>
                                    <span class="font-medium text-gray-900">{{ $ticket->telephone }}</span>
                                </div>
                            </div>
                            @if($ticket->societe)
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <div>
                                    <span class="block text-xs text-gray-500">Entreprise</span>
                                    <span class="font-medium text-gray-900">{{ $ticket->societe }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-row md:flex-col gap-3 w-full md:w-auto md:border-l border-gray-100 md:pl-6 pt-6 md:pt-0 border-t md:border-t-0">
                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                           class="flex-1 md:flex-none flex items-center justify-center bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-sm text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Détails
                        </a>
                        
                        @if($ticket->statut !== 'canceled')
                        <a href="{{ route('tickets.edit', $ticket->id) }}" 
                           class="flex-1 md:flex-none flex items-center justify-center bg-white border border-gray-200 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors font-medium shadow-sm text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier
                        </a>
                        @endif

                        <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" class="flex-1 md:flex-none flex"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce ticket ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center bg-white border border-red-200 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50 transition-colors font-medium shadow-sm text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
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
