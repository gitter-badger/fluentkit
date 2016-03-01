<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 50)->create();

        factory(\App\Models\Role::class, 50)->create();

        // create default test user
        $admin = \App\Models\User::firstOrCreate([
            'first_name' => 'Fluent',
            'last_name' => 'Kit',
            'email' => 'test@fluentkit.io',
            'password' => bcrypt('fluentkit')
        ]);

        $admin->assignRole('administrator');


        // $this->call(UserTableSeeder::class);
    }
}
