<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeiboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key',16)->comment("平台key(自用)");;
            $table->string('name',20)->comment("平台名称");
            $table->integer('visits')->comment("访问人数");
            $table->text('config')->comment("配置json");
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `gw_weibo` comment '微博管理表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weibo');
    }
}
