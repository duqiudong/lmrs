<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->nullable();
            $table->string('long_name', 100)->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('one_category_id')->nullable();
            $table->integer('two_category_id')->nullable();
            $table->integer('three_category_id')->nullable();
            $table->integer('shop_id')->nullable();
            $table->decimal('price', 19)->nullable();
            $table->integer('sold_count')->nullable();
            $table->integer('review_count')->nullable();
            $table->tinyInteger('status');
            $table->string('category_ids', 20)->nullable();
            $table->string('description')->nullable();
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::dropIfExists('products');
    }
}
