@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold border-b pb-2 w-full text-blue-800">Mes Notifications</h2>
        
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="ml-4 flex-shrink-0">
                @csrf
                <button type="submit" class="text-sm bg-white border border-blue-500 hover:bg-blue-50 text-blue-600 font-semibold py-2 px-4 rounded shadow-sm transition">
                    Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        @forelse($notifications as $notification)
            <div class="border-b last:border-b-0 p-5 hover:bg-gray-50 transition duration-150 {{ $notification->is_read ? 'opacity-75 bg-white' : 'bg-blue-50 border-l-4 border-l-blue-500' }}">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-1">
                            @if(!$notification->is_read)
                                <span class="w-2.5 h-2.5 bg-blue-600 rounded-full inline-block flex-shrink-0"></span>
                            @endif
                            <h3 class="text-lg font-bold text-gray-900 {{ $notification->is_read ? 'text-gray-600 font-semibold' : '' }}">
                                {{ $notification->title }}
                            </h3>
                            @if($notification->type)
                                <span class="text-xs font-medium text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full">{{ $notification->type }}</span>
                            @endif
                        </div>
                        <p class="text-gray-700 text-base leading-relaxed mt-2 {{ $notification->is_read ? 'text-gray-500' : '' }}">
                            {{ $notification->message }}
                        </p>
                        
                        <div class="mt-3 flex items-center space-x-4">
                            <span class="text-xs text-gray-400 font-medium">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->ticket_id)
                                <a href="{{ route('tickets.show', $notification->ticket_id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center">
                                    Voir le ticket
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex sm:flex-col space-x-3 sm:space-x-0 sm:space-y-3">
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-100 p-2 rounded-full text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition shadow-sm" title="Marquer comme lu">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette notification ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 p-2 rounded-full text-red-500 hover:bg-red-100 hover:text-red-700 transition shadow-sm" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-10 text-center bg-gray-50 flex flex-col items-center justify-center">
                <div class="bg-gray-100 p-4 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-xl font-medium text-gray-700">Aucune notification</p>
                <p class="text-gray-500 mt-2 max-w-sm">Vous êtes à jour ! Vous n'avez pas de nouvelles notifications pour le moment.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection