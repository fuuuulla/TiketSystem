<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Liste des notifications -->
                    @if(Auth::user()->notifications->count() > 0)
                        <div class="space-y-3">
                            @foreach(Auth::user()->notifications()->orderBy('created_at', 'desc')->get() as $notification)
                                <div class="border rounded p-4 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50 border-blue-300' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-bold text-gray-900">
                                                {{ $notification->title }}
                                                @if(!$notification->is_read)
                                                    <span class="ml-2 inline-block w-2 h-2 bg-blue-600 rounded-full"></span>
                                                @endif

                                                
                                            </p>
                                            <p class="text-gray-700 mt-1">{{ $notification->message }}</p>
                                            <p class="text-gray-500 text-sm mt-2">
                                                {{ $notification->created_at->format('d/m/Y H:i') }}
                                            </p>
</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            Vous n'avez pas de notifications
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>