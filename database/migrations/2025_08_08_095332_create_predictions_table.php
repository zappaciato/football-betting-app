<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedSmallInteger('predicted_home')->nullable()->comment('Typ: Home_goals');
            $table->unsignedSmallInteger('predicted_away')->nullable()->comment('Typ: Away_goals');

            // ile punktów przyznano po rozliczeniu meczu (dla ulatwienia przeliczania wyników)
            $table->integer('points_awarded')->default(0);
            // Klucz unikalny: jeden rekord na (turniej, mecz, user)
            $table->unique(['tournament_id', 'match_id', 'user_id'], 'predictions_unique_triplet');

            // pomocnicze indeksy pod typowe zapytania
            $table->index(['tournament_id', 'user_id']);
            $table->index(['match_id', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predictions');
    }
};
