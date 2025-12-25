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
 Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained()->onDelete('cascade');
    $table->decimal('sem1', 5, 2);
    $table->decimal('sem2', 5, 2);
    $table->decimal('sem3', 5, 2);
    $table->decimal('sem4', 5, 2);
    $table->decimal('sem5', 5, 2);
    $table->decimal('rata_rata', 5, 2); // Disimpan untuk memudahkan sorting/ranking
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
