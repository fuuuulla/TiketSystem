<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
    {
        Schema::create('hostings', function (Blueprint $table) {  
            $table->id(); 
            $table->string('nom'); // 03 pack fixe pas modifiable
            $table->decimal('prix', 8, 2); // max 999999.99
            $table->string('duree'); // text (1 mois, 6 mois, 1 an)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostings');
    }
};
