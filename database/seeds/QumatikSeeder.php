<?php

use Illuminate\Database\Seeder;

class QumatikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //
        \App\Models\Qumatik::create([
            'name'  =>  'Artic Bay',
            'dropbox_dir'   =>  '/Installations/Arcticbay/SmartQAMUTIK/incoming',
        ]);

        \App\Models\Qumatik::create([
            'name'  =>  'Artic Bay',
            'dropbox_dir'   =>  '/Arviat/SmartQAMUTIK/',
        ]);
    }
}
