<?php
//database/seeds/UsersTableSeeder.php
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $password = bcrypt('secret');

        \App\User::create([
            'name'     => $faker->name,
            'email'    => 'graphql@test.com',
            'password' => $password,
        ]);

        for ($i = 0; $i < 10; ++$i) {
            \App\User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'password' => $password,
            ]);
        }
    }
}
