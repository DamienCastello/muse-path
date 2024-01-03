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
        Schema::dropIfExists('resource_user');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('resource_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Resource::class)->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'resource_id']);
        });
    }
};
