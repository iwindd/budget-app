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
        Schema::create('budget_addresses', function (Blueprint $table) {
            $table->foreignId('budget_id')->constrained('budgets')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('from_id');
            $table->datetime('from_date');
            $table->integer('back_id');
            $table->datetime('back_date');
            $table->boolean('multiple');
            $table->string('plate');
            $table->decimal('distance', 8, 2);
            $table->string('show_as');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_addresses');
    }
};
