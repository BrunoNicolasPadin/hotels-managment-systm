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
        Schema::disableForeignKeyConstraints();

        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('type_id')->constrained('lovs');
            $table->foreignId('status_id')->constrained('lovs');
            $table->foreignId('user_id')->constrained('users');
            $table->string('total')->default(0);
            $table->string('file', 255)->nullable();
            $table->string('log', 255)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
