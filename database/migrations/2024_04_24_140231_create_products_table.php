<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
    
            $table->id();
            $table->string('reference'); // Référence du produit
            $table->string('designation'); // Désignation du produit
            $table->string('codebare')->nullable(); // Code à barre du produit (optionnel)
            $table->decimal('prix_achat', 10, 2)->nullable(); // Prix d'achat du produit
            $table->decimal('prix_vente', 10, 2)->nullable(); // Prix de vente du produit
            $table->integer('quantite')->nullable(); // Quantité en stock du produit
            $table->string('image',400)->nullable(); //  Image ;
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('classes')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
