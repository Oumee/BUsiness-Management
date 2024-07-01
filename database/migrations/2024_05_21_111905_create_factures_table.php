<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
           $table->string('numero', 50);
            $table->date('date_emission');
            $table->date('date_echeance')->nullable();
            $table->integer('status');
            $table->unsignedBigInteger('vente_id');
            $table->foreign('vente_id')->references('id')->on('ventes')->onDelete('cascade');
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->decimal('total_facture');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factures');
    }
}





     