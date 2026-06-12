<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <h1 class="text-xl font-bold">TicketSystem</h1>
                    </a>
                </div>

                <!-- Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(Auth::user()->is_admin)
                        <!-- Menu Admin : seulement Accueil + Espace Admin -->
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Accueil
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Espace Admin
                        </a>
                    @else
                        <!-- Menu Utilisateur normal -->
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <!-- Icône notification -->
                        <div class="relative flex items-center">
                            <a href="{{ route('notifications.index') }}" class="relative inline-block">
                                <svg class="w-6 h-6 text-gray-600 hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if(Auth::user()->unreadNotificationsCount() > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1 -translate-y-1 bg-red-600 rounded-full">
                                        {{ Auth::user()->unreadNotificationsCount() }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Déconnexion -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>