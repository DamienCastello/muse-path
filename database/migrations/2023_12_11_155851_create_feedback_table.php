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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->integer('user_id');
            $table->integer('track_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
        });
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
        });
    }
};
