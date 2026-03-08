<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord de l'administrateur avec tous les tickets.
     */
    public function index()
    {
        // Récupérer tous les tickets, du plus récent au plus ancien, en chargeant la relation "user" et "hosting"
        $tickets = Ticket::with(['user', 'hosting'])->latest()->paginate(20);

        return view('admin.dashboard', compact('tickets'));
    }

    /**
     * Met à jour le statut d'un ticket.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'statut' => 'required|in:pending,validated,canceled',
        ]);

        $ancienStatut = $ticket->statut;
        $nouveauStatut = $request->statut;

        // Mise à jour du statut
        $ticket->update(['statut' => $nouveauStatut]);

        // Si le statut a réellement changé, on notifie l'utilisateur
        if ($ancienStatut !== $nouveauStatut) {
            $statusTrans = [
                'pending' => 'mise en attente',
                'validated' => 'validée ✅',
                'canceled' => 'annulée ❌'
            ];

            // Création de la notification pour le propriétaire du ticket
            $ticket->user->notifications()->create([
                'ticket_id' => $ticket->id,
                'type' => 'status_update',
                'title' => 'Mise à jour de votre demande',
                'message' => "Votre demande pour l'hébergement {$ticket->hosting->nom} a été {$statusTrans[$nouveauStatut]}.",
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Statut mis à jour avec succès.');
    }
}
