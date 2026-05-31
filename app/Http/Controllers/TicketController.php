<?php

namespace App\Http\Controllers;
use App\Mail\NewTicketMail;
use App\Models\Hosting;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Afficher tous les tickets de l'utilisateur (Dashboard)
     */
    public function index()
    {
        $tickets = Ticket::with('hosting')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('dashboard', compact('tickets'));
    }
    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $hostings = Hosting::all();
        return view('tickets.create', compact('hostings'));
    }
    
    /**
     * SAVE - POST /tickets
     */
    public function store(Request $request)
    {
        // 1. VALIDER
        $validated = $request->validate([
            'hosting_id' => 'required|exists:hostings,id',
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'societe' => 'nullable|string|max:255',
        ]);

        // 2. CRÉER le ticket
        $ticket = Ticket::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'statut' => 'pending'
        ]));

        // 3. ⭐ CRÉER une notification
        Auth::user()->notifyTicketCreated($ticket);

        // 4. 📧 Envoyer un email à l'administrateur
try {
    $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL', 'boudoumifella@gmail.com'));
    Mail::to($adminEmail)->send(new NewTicketMail($ticket));
} catch (\Exception $e) {
    \Log::error('Email failed: ' . $e->getMessage());
}

        // 5. REDIRECTION avec message
        return redirect()->route('dashboard')
            ->with('success', 'Ticket créé avec succès! 🎉');
    } 
    
    /**
     * Afficher un ticket spécifique
     */
    public function show($id)
    {
        $ticket = Ticket::with('hosting')->findOrFail($id);
        // Vérifier que le ticket appartient à l'utilisateur connecté
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('tickets.show', compact('ticket'));
    }
    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        // Vérifier que le ticket appartient à l'utilisateur connecté
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $hostings = Hosting::all();
        return view('tickets.edit', compact('ticket', 'hostings'));
    }

    /**
     * Mettre à jour un ticket
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Vérifier que le ticket appartient à l'utilisateur connecté
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'societe' => 'nullable|string|max:255',
            'hosting_id' => 'required|exists:hostings,id',
            'statut' => 'required|in:pending,validated,canceled',
        ]);

        $ticket->update($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket mis à jour avec succès !');
    }

    /**
     * Supprimer un ticket
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Vérifier que le ticket appartient à l'utilisateur connecté
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $ticket->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket supprimé avec succès !');
    }

    /**
     * Annuler un ticket (changement de statut)
     */
    public function cancel($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Vérifier que le ticket appartient à l'utilisateur connecté
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        $ticket->update(['statut' => 'canceled']);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ticket annulé avec succès !');
    }

    
}