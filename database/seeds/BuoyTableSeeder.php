<?php

use Illuminate\Database\Seeder;

class BuoyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //
        \App\Buoy::insert([
            'imei'          =>  '300234066297641',
            'asset_name'    =>  'testing',
            'plan'          =>  1,
            'back_office'   =>  0,
            'status'        =>  0,
            'user_id'       =>  9001
        ]);

    }
}
