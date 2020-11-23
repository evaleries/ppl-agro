<?php

use App\Models\User;
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
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'J.Coffee',
            'password' => app('hash')->make('123'),
            'email' => 'admin@jcoffee.test'
        ]);

        $admin->assignRole('admin');

        factory(User::class, 15)->create()->each(fn ($u) => $u->assignRole('user'));
    }
}
