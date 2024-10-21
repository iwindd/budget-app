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
        Schema::create('budget_item_travel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_item_id')->constrained('budget_items')->onDelete('cascade')->onUpdate('cascade');
            $table->date('start');
            $table->date('end');
            $table->string('n');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_item_travel');
    }
};
