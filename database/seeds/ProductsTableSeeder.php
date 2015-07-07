<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Product;


class ProductsTableSeeder extends Seeder {

    /**
     *
     */
    public function run()
    {
        $faker = Faker::create();
        $usersIds = User::lists('id')->all();
        factory(Product::class, 10)->create([
            'user_id'     => $faker->randomElement($usersIds),
        ]);

    }
}