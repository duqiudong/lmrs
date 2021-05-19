<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddr extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('user_addrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('zip')->nullable()->comment('邮编');
            $table->integer('province')->nullable()->comment('省');
            $table->integer('city')->nullable()->comment('市');
            $table->integer('area')->nullable()->comment('区');
            $table->string('address', 200)->nullable()->comment('详细地址');
            $table->tinyInteger('is_default')->default(0)->comment('是否默认地址');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::dropIfExists('user_addr');
    }
}
