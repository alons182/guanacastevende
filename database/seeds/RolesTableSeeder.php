<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder {

    public function run()
    {

        factory(Role::class, 1)->create();
        factory(Role::class, 1)->create([
            'name' => 'member',
        ]);





    }

}