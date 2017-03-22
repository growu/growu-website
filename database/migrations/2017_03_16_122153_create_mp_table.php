<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key',16)->comment("公众平台key(自用)");;
            $table->string('name',20)->comment("公众平台名称");
            $table->integer('visits')->comment("访问人数");
            $table->text('config')->comment("配置json");
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `gw_mp` comment '公众平台管理表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp');
    }
}
