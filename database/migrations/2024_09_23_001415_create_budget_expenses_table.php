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
        Schema::create('budget_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('budget_id')->constrained('budgets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('days')->nullable();
            $table->string('type')->nullable();
            $table->decimal('total', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_expenses');
    }
};
