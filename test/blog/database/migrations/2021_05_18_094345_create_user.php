<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10)->unique()->comment('昵称');
            $table->string('mobile', 11)->comment('手机号');
            $table->string('password', 60)->nullable()->comment('密码');
            $table->string('email')->nullable()->comment('邮箱');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
