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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('room_number'); // Vagy foreignId('room_id') ha van szoba táblád
            $table->decimal('total_price');
            $table->text('internal_notes')->nullable(); // Megjegyzés a személyzetnek
            $table->text('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
