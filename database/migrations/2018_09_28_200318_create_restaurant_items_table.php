<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_items', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_id');
            $table->unsignedInteger('item_id');
            $table->float('price', 4, 2)->default(0);
            $table->timestamps();

            $table->foreign('restaurant_id')
                  ->references('id')
                  ->on('restaurants')
                  ->onDelete('cascade');

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_items');
    }
}
