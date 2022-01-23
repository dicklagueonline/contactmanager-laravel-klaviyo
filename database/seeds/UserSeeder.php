<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 15)->create()->each(function ($user) {
            $user->contacts()->saveMany(factory(App\Models\Contact::class, 25)->make());
        });
    }
}
