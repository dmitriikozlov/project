<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->string('name');

            // соленое острое легкое
            $table->string('type');

            $table->float('protein');
            $table->float('fat');
            $table->float('carbohydrate');
            $table->float('calory');
            $table->float('joule');

            $table->float('price');
            $table->float('price_amount');
            $table->float('weight');

            $table->string('text_color');
            $table->string('color');

            $table->integer('amount');

            $table->string('image');

            $table->text('recipe');

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
        Schema::drop('products');
    }
}
