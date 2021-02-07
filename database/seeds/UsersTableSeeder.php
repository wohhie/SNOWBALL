<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $role_operator = \App\Role::where('name', 'operator')->first();
        $role_manager  = \App\Role::where('name', 'manager')->first();

        // operator information updated
        $operator = new \App\User();
        $operator->firstname = "Neo";
        $operator->lastname = "Anderson";
        $operator->email = "operator@smartice.org";
        $operator->password = bcrypt("operator");
        $operator->save();
        $operator->roles()->attach($role_operator);


        // Manager information updated
        $manager = new \App\User();
        $manager->firstname = "Tyler";
        $manager->lastname = "Spurrell";
        $manager->email = "manager@smartice.org";
        $manager->password = bcrypt("manager");
        $manager->save();
        $manager->roles()->attach($role_manager);





    }
}
