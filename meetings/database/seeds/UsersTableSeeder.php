<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // $this->call(UserTableSeeder::class);
        DB::table('users')->delete();

        $users = array(
            ['first_name' => 'Ryan', 'last_name'=> 'Chenkie', 'email' => 'ryanchenkie@gmail.com', 'password' => Hash::make('secret')],
            ['first_name' => 'Chris', 'last_name'=>  'Sevilleja', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret')],
            ['first_name' => 'Holly', 'last_name'=> 'Lloyd', 'email' => 'holly@scotch.io', 'password' => Hash::make('secret')],
            ['first_name' => 'Adnan', 'last_name' => 'Kukic', 'email' => 'adnan@scotch.io', 'password' => Hash::make('secret')],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            App\User::create($user);
        }


    }
}
