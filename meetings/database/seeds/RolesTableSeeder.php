<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->delete();

        $roles = array(
            ['name' => 'owner', 'display_name'=> 'Owner', 'description' => 'Owns and manages the account'],
            ['name' => 'manager', 'display_name'=> 'Manager', 'description' => 'Manages the account'],
            ['name' => 'member', 'display_name'=> 'Member', 'description' => 'Belongs to an account as an added member, sees information cannot edit information']
        );

        // Loop through each user above and create the record for them in the database
        foreach ($roles as $role)
        {
            App\Role::create($role);
        }


    }
}
