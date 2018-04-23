<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',16)->comment("名称");;
            $table->string('remark',50)->comment("备注");
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `gw_app` comment '应用管理表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
