<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('plans')->delete();

        $plans = array(
            ['type' => 'messages', 'name'=> 'free messaging', 'description' => 'standard one to one messages limit 50 per month', 'cost' => '0.00'],
            ['type' => 'messages', 'name'=> 'user messaging', 'description' => 'unlimited one to one messages', 'cost' => '50.00'],
            ['type' => 'messages', 'name'=> 'group messaging', 'description' => 'unlimited message threads, group chats, and one to one messages', 'cost' => '75.00'],
            ['type' => 'messages', 'name'=> 'broadcast messaging', 'description' => 'unlimited broadcasts, message threads and one to one messages', 'cost' => '100.00'],
            ['type' => 'events', 'name'=> 'free events', 'description' => 'an events calendar with one event a day limit', 'cost' => '0.00'],
            ['type' => 'events', 'name'=> 'appointment events', 'description' => 'an events calendar with unlimited slots with signup for one user', 'cost' => '50.00'],
            ['type' => 'events', 'name'=> 'meeting events', 'description' => 'an events calendar with unlimited slots and signup for multiple users', 'cost' => '75.00'],
            ['type' => 'users', 'name'=> 'free users', 'description' => 'free for you with limited member users', 'cost' => '0.00'],
            ['type' => 'users', 'name'=> 'small users', 'description' => 'unlimited member users', 'cost' => '50.00'],
            ['type' => 'users', 'name'=> 'large users', 'description' => 'unlimited member users, unlimited manager users', 'cost' => '75.00'],



        );

        // Loop through each user above and create the record for them in the database
        foreach ($plans as $plan)
        {
            Billing\MessagePlan::create($plan);
        }


    }
}
