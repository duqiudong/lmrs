<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrands extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('logo', 100)->nullable();
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
        Schema::dropIfExists('brands');
    }
}
