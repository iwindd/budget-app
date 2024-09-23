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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->string('title');
            $table->string('place');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date');
            $table->date('order_at');
            $table->integer('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
