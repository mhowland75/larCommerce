<?php

use Illuminate\Support\Facades\Schema;
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
          $table->string('primary_category');
          $table->string('secondary_category');
          $table->decimal('price',5,2);
          $table->integer('stock');
          $table->integer('low_stock_level');
          $table->string('sku');
          $table->boolean('active');
          $table->integer('times_viewed');
          $table->integer('times_ordered');
          $table->boolean('size_variation');
          $table->integer('discount_percentage');
          $table->integer('average_rating');
          $table->string('description');
          $table->integer('weight');
          $table->integer('langth');
          $table->integer('width');
          $table->integer('height');
          $table->SoftDeletes();
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
