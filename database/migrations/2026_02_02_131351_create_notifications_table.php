<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // ID et relations
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            
            // Contenu de la notification
            $table->string('type'); // 'ticket_created', 'ticket_updated', etc
            $table->string('title'); // Ex: "Nouveau ticket créé"
            $table->text('message'); // Ex: "Votre ticket pour Pack Pro a été créé"
            
            // Statut
            $table->boolean('is_read')->default(false); // Marquer comme lu
            
            // Timestamps
            $table->timestamps();
            
            // Index pour recherche rapide
            $table->index('user_id');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};