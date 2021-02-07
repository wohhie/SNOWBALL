<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        // employee
        $role_operator = new \App\Role();
        $role_operator->name = "operator";
        $role_operator->description = "An Operator";
        $role_operator->save();


        // manager
        $role_manager = new \App\Role();
        $role_manager->name = "manager";
        $role_manager->description = "A Manager";
        $role_manager->save();
    }
}
