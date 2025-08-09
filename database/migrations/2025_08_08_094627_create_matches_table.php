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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            // (opcjonalnie) powiązanie z tabelą teams zamiast stringów
            $table->string('home_team');
            $table->string('away_team');
            // jeśli chcesz normalizować: zamiast powyższych -> home_team_id, away_team_id (FK do teams)
            $table->dateTime('match_date')->index()->comment('Data/godzina meczu');
            // wynik (nullable do momentu zakończenia meczu)
            $table->smallInteger('result_home')->nullable()->comment('Gole gospodarzy (po meczu)');
            $table->smallInteger('result_away')->nullable()->comment('Gole gości (po meczu)');
            $table->timestamps();
            $table->unique(['id', 'home_team', 'away_team', 'match_date'], 'unique_match_tournament');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
