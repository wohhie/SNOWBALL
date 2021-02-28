<?php

use Illuminate\Database\Seeder;

class CommunitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        // truncate table
        \App\Models\Community::truncate();

        // insert initial datas
        App\Models\Community::insert([
            'name'          =>  'Nain',
            'latitude'      =>  '56.541683',
            'longitude'     =>  '-61.696888',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);

        \App\Models\Community::insert([
            'name'          =>  'Pangnirtung',
            'latitude'      =>  '66.1464200',
            'longitude'     =>  '-65.6999600',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);

        \App\Models\Community::insert([
            'name'          =>  'Qikiqtarjuaq',
            'latitude'      =>  '62.686669',
            'longitude'     =>  '-70.602425',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);

        \App\Models\Community::insert([
            'name'          =>  'Cape Dorset',
            'latitude'      =>  '64.230375',
            'longitude'     =>  '-76.540963',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);

        \App\Models\Community::insert([
            'name'          =>  'Sanikiluaq',
            'latitude'      =>  '56.540768',
            'longitude'     =>  '-79.22321',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);

        \App\Models\Community::insert([
            'name'          =>  'Hall Beach',
            'latitude'      =>  '68.772735',
            'longitude'     =>  '-81.235208',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);


        \App\Models\Community::insert([
            'name'          =>  'Igloolik',
            'latitude'      =>  '69.372505',
            'longitude'     =>  '-81.82465',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);


        \App\Models\Community::insert([
            'name'          =>  'Gjoa Haven',
            'latitude'      =>  '68.635556',
            'longitude'     =>  '-95.849722',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);


        \App\Models\Community::insert([
            'name'          =>  'Tuktoyaktuk',
            'latitude'      =>  '69.445358',
            'longitude'     =>  '-133.034181',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);


        \App\Models\Community::insert([
            'name'          =>  'Pond Inlet',
            'latitude'      =>  '72.700117',
            'longitude'     =>  '-77.958532',
            'created_at'    =>  date('Y-m-d H:i:s'),
            'updated_at'    =>  date('Y-m-d H:i:s')
        ]);



    }
}
