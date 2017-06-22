<?php

use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->delete();
        Schema::disableForeignKeyConstraints();

        $roles = array(
            ['role_id'=> 1, 'permission_id' => 7],
            ['role_id'=> 1, 'permission_id' => 8],
            ['role_id'=> 1, 'permission_id' => 9],
            ['role_id'=> 1, 'permission_id' => 10],
            ['role_id'=> 1, 'permission_id' => 11],
            ['role_id'=> 1, 'permission_id' => 12],
            ['role_id'=> 2, 'permission_id' => 10],
            ['role_id'=> 2, 'permission_id' => 11],
            ['role_id'=> 2, 'permission_id' => 12],
            ['role_id'=> 3, 'permission_id' => 11],
            ['role_id'=> 1, 'permission_id' => 12]

        );

        // Loop through each user above and create the record for them in the database
        foreach ($roles as $role)
        {
            App\PermissionRole::create($role);
        }

    }
}
