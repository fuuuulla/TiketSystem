<?php

namespace Tests\Feature; //dit à Laravel que ce fichier est dans le dossier tests/Feature/ 


//Les use importent les classes dont on a besoin : modèles, mail, et outils de test
use App\Models\Hosting;
use App\Models\Ticket;
use App\Models\User;
use App\Mail\NewTicketMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase; // recrée les tables à chaque test



    /** Crée un utilisateur et le connecte */
    private function loginUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user); // simule un utilisateur connecté
        return $user;
    }

    /** Crée un utilisateur admin et le connecte */
    private function loginAdmin(): User
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin); // simule un utilisateur admin connecté
        return $admin;
    }

    /** Crée une offre d'hébergement */
    private function makeHosting(): Hosting
    {
        return Hosting::create([
            'nom'   => 'Pack Basic',
            'prix'  => 99.00,
            'duree' => 12,
        ]);
    }

    // =========================================================
    // TESTS — AFFICHAGE (GET)
    // =========================================================

    /** Test 1 : Un utilisateur connecté peut voir le formulaire de création */
    public function test_user_can_see_create_ticket_form(): void
    {
        $this->makeHosting();
        $this->loginUser();

        $response = $this->get(route('tickets.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tickets.create');
        $response->assertViewHas('hostings');
    }

    /** Test 2 : Un visiteur non connecté est redirigé vers login */
    public function test_guest_cannot_access_create_ticket_form(): void
    {
        $response = $this->get(route('tickets.create'));

        $response->assertRedirect(route('login'));
    }

    /** Test 3 : L'utilisateur voit son dashboard avec ses tickets */
    public function test_user_can_see_dashboard_with_his_tickets(): void
    {
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        Ticket::create([
            'user_id'    => $user->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Ali Test',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('tickets');
    }

    // =========================================================
    // TESTS — CRÉATION (POST)
    // =========================================================

    /** Test 4 : Un utilisateur peut créer un ticket avec des données valides */
    public function test_user_can_create_ticket_with_valid_data(): void
    {
        Mail::fake();
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        // ACT — exécuter l'action à tester
        $response = $this->post(route('tickets.store'), [
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Mohamed Amine',
            'telephone'   => '0555123456',
            'adresse'     => '12 Rue Didouche Mourad, Alger',
            'societe'     => 'TechCorp',
        ]);

        // ASSERT — vérifier le résultat
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'user_id'     => $user->id,
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Mohamed Amine',
            'statut'      => 'pending',
        ]);
    }

    /** Test 5 : Le statut initial d'un ticket est toujours "pending" = en attente */
    public function test_new_ticket_has_pending_status_by_default(): void
    {
        Mail::fake();
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        $this->post(route('tickets.store'), [
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Test User',
            'telephone'   => '0555000000',
            'adresse'     => 'Oran',
        ]);

        $ticket = Ticket::where('user_id', $user->id)->first();
        $this->assertEquals('pending', $ticket->statut);
    }

    /** Test 6 : La création échoue si hosting_id est manquant */
    public function test_ticket_creation_fails_without_hosting_id(): void
    {
        $this->loginUser();

        $response = $this->post(route('tickets.store'), [
            'nom_complet' => 'Test',
            'telephone'   => '0555000000',
            'adresse'     => 'Alger',
        ]);

        $response->assertSessionHasErrors('hosting_id');
        $this->assertDatabaseCount('tickets', 0);
    }

    /** Test 7 : La création échoue si nom_complet est manquant */
    public function test_ticket_creation_fails_without_nom_complet(): void
    {
        $this->loginUser();
        $hosting = $this->makeHosting();

        $response = $this->post(route('tickets.store'), [
            'hosting_id' => $hosting->id,
            'telephone'  => '0555000000',
            'adresse'    => 'Alger',
        ]);

        $response->assertSessionHasErrors('nom_complet');
    }

    /** Test 8 : La création échoue si hosting_id n'existe pas en base */
    public function test_ticket_creation_fails_with_invalid_hosting_id(): void
    {
        $this->loginUser();

        $response = $this->post(route('tickets.store'), [
            'hosting_id'  => 9999,
            'nom_complet' => 'Test',
            'telephone'   => '0555000000',
            'adresse'     => 'Alger',
        ]);

        $response->assertSessionHasErrors('hosting_id');
    }

    /** Test 9 : Un email est envoyé à l'admin après la création d'un ticket */
    public function test_email_is_sent_to_admin_after_ticket_creation(): void
    {
        Mail::fake();
        $this->loginUser();
        $hosting = $this->makeHosting();

        $this->post(route('tickets.store'), [
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Test User',
            'telephone'   => '0555000000',
            'adresse'     => 'Alger',
        ]);

        Mail::assertSent(NewTicketMail::class);
    }

    // =========================================================
    // TESTS — AFFICHAGE D'UN TICKET (show)
    // =========================================================

    /** Test 10 : Un utilisateur peut voir son propre ticket */
    public function test_user_can_view_his_own_ticket(): void
    {
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $user->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Ali',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->get(route('tickets.show', $ticket->id));

        $response->assertStatus(200);
        $response->assertViewIs('tickets.show');
    }

    /** Test 11 : Un utilisateur ne peut PAS voir le ticket d'un autre */
    public function test_user_cannot_view_another_users_ticket(): void
    {
        $owner = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Propriétaire',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $this->loginUser(); // connecte un autre utilisateur

        $response = $this->get(route('tickets.show', $ticket->id));
        $response->assertStatus(403);
    }

    // =========================================================
    // TESTS — MISE À JOUR (PUT)
    // =========================================================

    /** Test 12 : Un utilisateur peut modifier son ticket */
    public function test_user_can_update_his_ticket(): void
    {
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $user->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Ancien Nom',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->put(route('tickets.update', $ticket->id), [
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Nouveau Nom',
            'telephone'   => '0661234567',
            'adresse'     => 'Oran',
            'statut'      => 'pending',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('tickets', [
            'id'          => $ticket->id,
            'nom_complet' => 'Nouveau Nom',
        ]);
    }

    /** Test 13 : Un utilisateur ne peut PAS modifier le ticket d'un autre */
    public function test_user_cannot_update_another_users_ticket(): void
    {
        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Propriétaire',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $this->loginUser();

        $response = $this->put(route('tickets.update', $ticket->id), [
            'hosting_id'  => $hosting->id,
            'nom_complet' => 'Hacker',
            'telephone'   => '0000000000',
            'adresse'     => 'Inconnue',
            'statut'      => 'validated',
        ]);

        $response->assertStatus(403);
    }

    // =========================================================
    // TESTS — SUPPRESSION (DELETE)
    // =========================================================

    /** Test 14 : Un utilisateur peut supprimer son ticket */
    public function test_user_can_delete_his_ticket(): void
    {
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $user->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'A Supprimer',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->delete(route('tickets.destroy', $ticket->id));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    /** Test 15 : Un utilisateur ne peut PAS supprimer le ticket d'un autre */
    public function test_user_cannot_delete_another_users_ticket(): void
    {
        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Protégé',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $this->loginUser();

        $response = $this->delete(route('tickets.destroy', $ticket->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);
    }

    // =========================================================
    // TESTS — ANNULATION
    // =========================================================

    /** Test 16 : Un utilisateur peut annuler son ticket */
    public function test_user_can_cancel_his_ticket(): void
    {
        $user    = $this->loginUser();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $user->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Ali',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->patch(route('tickets.cancel', $ticket->id));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('tickets', [
            'id'     => $ticket->id,
            'statut' => 'canceled',
        ]);
    }

    /** Test 17 : Un utilisateur ne peut PAS annuler le ticket d'un autre */
    public function test_user_cannot_cancel_another_users_ticket(): void
    {
        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Ali',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $this->loginUser();

        $response = $this->patch(route('tickets.cancel', $ticket->id));
        $response->assertStatus(403);
    }

    // =========================================================
    // TESTS — ADMIN
    // =========================================================

    /** Test 18 : L'admin peut voir tous les tickets */
    public function test_admin_can_see_all_tickets(): void
    {
        $this->loginAdmin();

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas('tickets');
    }

    /** Test 19 : Un utilisateur normal ne peut PAS accéder au dashboard admin */
    public function test_normal_user_cannot_access_admin_dashboard(): void
    {
        $this->loginUser();

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    /** Test 20 : L'admin peut changer le statut d'un ticket vers "validated" */
    public function test_admin_can_validate_a_ticket(): void
    {
        Mail::fake();
        $this->loginAdmin();

        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Client',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->patch(route('admin.tickets.updateStatus', $ticket->id), [
            'statut' => 'validated',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'id'     => $ticket->id,
            'statut' => 'validated',
        ]);
    }

    /** Test 21 : L'admin peut changer le statut d'un ticket vers "canceled" */
    public function test_admin_can_cancel_a_ticket(): void
    {
        Mail::fake();
        $this->loginAdmin();

        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Client',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->patch(route('admin.tickets.updateStatus', $ticket->id), [
            'statut' => 'canceled',
        ]);

        $this->assertDatabaseHas('tickets', [
            'id'     => $ticket->id,
            'statut' => 'canceled',
        ]);
    }

    /** Test 22 : Un statut invalide est rejeté par l'admin */
    public function test_admin_cannot_set_invalid_status(): void
    {
        $this->loginAdmin();

        $owner   = User::factory()->create();
        $hosting = $this->makeHosting();

        $ticket = Ticket::create([
            'user_id'    => $owner->id,
            'hosting_id' => $hosting->id,
            'nom_complet'=> 'Client',
            'telephone'  => '0550000000',
            'adresse'    => 'Alger',
            'statut'     => 'pending',
        ]);

        $response = $this->patch(route('admin.tickets.updateStatus', $ticket->id), [
            'statut' => 'INVALID_STATUS',
        ]);

        $response->assertSessionHasErrors('statut');
    }
}