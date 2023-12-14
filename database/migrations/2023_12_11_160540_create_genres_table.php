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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('genre_track', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Track::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Genre::class)->constrained()->cascadeOnDelete();
            $table->primary(['track_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_track');
        Schema::dropIfExists('genres');
    }
};
