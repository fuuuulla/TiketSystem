@extends('layouts.app')

@section('title', 'Espace Administrateur - Gestion des Demandes')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 gap-4 relative overflow-hidden">
        <div class="absolute right-0 top-0 -mr-16 -mt-16 w-48 h-48 bg-purple-50 rounded-full blur-3xl opacity-70"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-800 to-indigo-800 tracking-tight">Panneau d'Administration</h1>
            <p class="text-gray-500 mt-1">Supervisez et gérez toutes les demandes d'hébergement.</p>
        </div>
        
        <div class="relative z-10 flex gap-4">
            <div class="bg-gray-50 border border-gray-200 px-4 py-2 rounded-lg flex flex-col justify-center items-center">
                <span class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total</span>
                <span class="text-xl font-bold text-gray-800">{{ $tickets->total() }}</span>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Demande</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pack & Tarif</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions Administrateur</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200 mr-3">
                                        {{ substr($ticket->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $ticket->nom_complet }}</div>
                                        <div class="text-xs text-gray-500">{{ $ticket->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-blue-700">{{ $ticket->hosting->nom }}</div>
                                <div class="text-sm text-gray-600">{{ number_format($ticket->hosting->prix, 0, ',', ' ') }} DA / {{ $ticket->hosting->duree }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($ticket->statut === 'pending')
                                    <span class="inline-flex items-center rounded-md bg-yellow-50 px-2.5 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-inset ring-yellow-600/20">En attente</span>
                                @elseif($ticket->statut === 'validated')
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">Validé</span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/10">Annulé</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg transition-colors" title="Voir les détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="statut" onchange="this.form.submit()" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 font-medium shadow-sm cursor-pointer @if($ticket->statut === 'pending') bg-yellow-50 @elseif($ticket->statut === 'validated') bg-green-50 @else bg-red-50 @endif">
                                                <option value="pending" {{ $ticket->statut === 'pending' ? 'selected' : '' }}>En attente</option>
                                                <option value="validated" {{ $ticket->statut === 'validated' ? 'selected' : '' }}>Valider</option>
                                                <option value="canceled" {{ $ticket->statut === 'canceled' ? 'selected' : '' }}>Annuler</option>
                                            </select>
                                        </form>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer DÉFINITIVEMENT ce ticket ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition-colors ml-2" title="Supprimer de la base">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900">Aucune demande d'hébergement</p>
                                    <p class="text-sm mt-1">Les utilisateurs n'ont pas encore soumis de demandes.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
