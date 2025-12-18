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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            //Alap dolgok
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_number');

            //Személyes dolgok
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('address');

            //Jogi, személyesebb dolgok
            $table->date('date_of_birth')->nullable();
            $table->string('document_number')->nullable();
            $table->string('nationality')->nullable();
            // Egyéb dolgok
            $table->text('notes')->nullable();
            $table->string('language')->nullable();

            $table->string('source')->nullable();
            // Tábla összekötés
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
