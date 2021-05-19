<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipLevelInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_level_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->nullable()->comment('会员等级名称');
            $table->bigInteger('min_point')->nullable()->comment('最低积分');
            $table->bigInteger('max_point')->nullable()->comment('最高积分');
            $table->dateTime('last_time')->nullable();
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
        Schema::dropIfExists('vip_level_infos');
    }
}
