<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SimpleTest extends DuskTestCase
{
    public function test_robot_ultra_simple(): void
    {
        $this->browse(function (Browser $browser) {
            
            // 1. Accueil
            $browser->visit('http://127.0.0.1:8000')
                    ->pause(3000)
                    ->screenshot('01-accueil');

            // 2. Register (direct)
            $browser->visit('http://127.0.0.1:8000/register')
                    ->pause(2000)
                    ->type('input[name="name"]', 'Robot')
                    ->type('input[type="email"]', 'r'.time().'@test.com')
                    ->type('input[name="password"]', 'passwrd123')
                    ->type('input[name="password_confirmation"]', 'passwrd123')
                    ->click('button[type="submit"]')
                    ->pause(5000)
                    ->screenshot('02-inscrit');

            // 3. Créer ticket (direct)
            $browser->visit('http://127.0.0.1:8000/tickets/create')
                    ->pause(2000)
                    ->type('input[name="nom_complet"]', 'Ahmed')
                    ->type('input[name="telephone"]', '0555')
                    ->type('textarea[name="adresse"]', 'Alger')
                    ->select('select[name="hosting_id"]', '1')
                    ->click('button[type="submit"]')
                    ->pause(5000)
                    ->screenshot('03-ticket');

            // 4. Dashboard (direct)
            $browser->visit('http://127.0.0.1:8000/dashboard')
                    ->pause(3000)
                    ->screenshot('04-dashboard');

            // 5. Fin
            $browser->visit('http://127.0.0.1:8000')
                    ->pause(5000)
                    ->screenshot('05-fin');
        });
    }
}