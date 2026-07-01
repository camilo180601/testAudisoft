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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            // La categoría es obligatoria. restrictOnDelete impide, a nivel de BD,
            // borrar una categoría que esté en uso por algún sitio.
            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
