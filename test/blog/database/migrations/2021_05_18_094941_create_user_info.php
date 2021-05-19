<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name', 10)->nullable()->comment('真实姓名');
            $table->tinyInteger('identity_card_type')->nullable()->comment('证件类型');
            $table->tinyInteger('gender')->nullable()->default(1)->comment('性别');
            $table->integer('user_point')->nullable()->comment('用户积分');
            $table->string('identity_card_no', 20)->nullable()->comment('证件号码');
            $table->date('birthday')->nullable()->comment('生日');
            $table->integer('vip_level')->nullable()->comment('会员等级');
            $table->integer('age')->nullable()->comment('年龄');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}
