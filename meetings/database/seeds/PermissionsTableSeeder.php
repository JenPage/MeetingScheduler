<?php


use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('permissions')->delete();

        $permissions = array(
            ['name' => 'edit_payment', 'display_name'=> 'Edit Payment', 'description' => 'create read update delete payment information'],
            ['name' => 'edit_location', 'display_name'=> 'Edit Location', 'description' => 'create read update delete company location information'],
            ['name' => 'edit_managers', 'display_name'=> 'Edit Managers', 'description' => 'create read update delete manager information'],
            ['name' => 'edit_members', 'display_name'=> 'Edit Payment', 'description' => 'create read update delete member information'],
            ['name' => 'edit_broadcast', 'display_name'=> 'Edit Broadcasts', 'description' => 'create read update delete broadcast information'],
            ['name' => 'edit_message', 'display_name'=> 'Edit Message', 'description' => 'create read update delete message information']
        );

        // Loop through each user above and create the record for them in the database
        foreach ($permissions as $permission)
        {
            App\Permission::create($permission);
        }


    }
}
