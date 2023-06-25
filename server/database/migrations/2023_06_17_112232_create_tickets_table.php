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
        Schema::create('tickets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('event_id')->constrained();
            $table->foreignUlid('ticket_type_id')->constrained();
            $table->foreignUlid('user_id')->constrained();
            $table->string('ticket_number')->unique();
            $table->unsignedInteger('amount_paid');
            $table->foreignUlid('currency_id')->constrained();
            $table->boolean('payment_confirmed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
