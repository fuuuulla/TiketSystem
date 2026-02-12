<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICOSNET - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
   <!-- Navbar -->
<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold">ICOSNET</h1>
                <a href="{{ route('home') }}" class="hover:text-blue-200">Accueil</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200">Dashboard</a>
                @endauth
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <span>Bonjour, {{ Auth::user()->name }}</span>
                    <a href="{{ route('tickets.create') }}" 
                       class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-blue-50">
                        ✚ Nouvelle demande
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-200">Connexion</a>
                    <a href="{{ route('register') }}" 
                       class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-blue-50">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 ICOSNET - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>