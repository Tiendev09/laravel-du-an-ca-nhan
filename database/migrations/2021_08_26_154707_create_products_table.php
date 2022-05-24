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
            $table->text('thumbnail');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->text('content');
            $table->string('intro');
            $table->unsignedBigInteger('cat_id');
            $table->string('status')->nullable();
            $table->foreign('cat_id')->references('id')->on('product_cats')->onDelete('cascade');
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
