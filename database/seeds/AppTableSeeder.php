<?php

use Illuminate\Database\Seeder;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('app')->insert([
            [
                'id'   => 101,
                'name' => 'drip_android',
                'remark' => '水滴打卡安卓'
            ],
            [
                'id'   => 102,
                'name' => 'drip_ios',
                'remark' => '水滴打卡IOS'
            ],
            [
                'id'   => 103,
                'name' => 'drip_weapp',
                'remark' => '水滴打卡微信小程序'
            ]
        ]);
    }
}
