<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJeusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jeus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('is_publie')->default(0);
            $table->integer('is_demande_publie')->default(0)->nullable();
            $table->string('slug')->nullable();
            $table->string('jeu')->nullable();
            $table->string('languages')->nullable();
            $table->text('presentation')->nullable();
            $table->text('intro')->nullable();
            $table->text('image')->nullable();
            $table->string('licence')->nullable();
            $table->string('image_licence')->nullable();
            $table->string('image_auteur')->nullable();
            $table->string('auteur_nom')->nullable();
            $table->string('auteur_email')->nullable();
            $table->string('auteur_url')->nullable();
            $table->string('auteur_rs')->nullable();

            $table->integer('duree_rapide')->nullable();
            $table->integer('duree_moyenne')->nullable();
            $table->integer('duree_longue')->nullable();

            $table->timestamps();
        });




        Schema::table('jeus', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jeus');
    }
}
