<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',20)->comment("帐号");
            $table->string('email',50)->comment("电子邮箱");
            $table->string('phone',20)->comment("手机号码");
            $table->string('nickname',50)->comment("昵称");
            $table->string('realname',20)->comment("真实姓名");
            $table->tinyInteger('sex')->comment("性别，0未知 1男 2女");
            $table->string('city',20)->comment("城市");
            $table->string('province',20)->comment("省份");
            $table->string('country',20)->comment("国家");
            $table->string('location',50)->comment("未知地理描述");
            $table->string('avatar',200)->comment("头像的URL地址");
            $table->string('avatar',200)->comment("头像的URL地址");
            $table->string('remark',50)->comment("备注");
            $table->string('source',50)->comment("注册来源");
            $table->string('reg_ip',50)->comment("注册IP");
            $table->string('last_login_ip',50)->comment("最后登录时间");
            $table->timestamp('reg_time',50)->comment("注册时间");
            $table->timestamp('last_login_time',50)->comment("最后登录时间");
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `gw_user` comment '用户表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('user');
    }
}
