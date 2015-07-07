<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use App\Profile;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {

        factory(User::class, 1)->create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt("123456"),
            'remember_token' => str_random(10),
        ]);
        factory(Profile::class, 1)->create([
            'user_id' => 1
        ]);
        factory(User::class, 5)->create()->each(function($u) {
            $u->profile()->save(factory(App\Profile::class)->make());
        });


    }

}