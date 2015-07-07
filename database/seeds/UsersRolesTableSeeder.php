<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersRolesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1
        ]);
        $usersIds = User::lists('id')->all();
        $rolesIds = Role::lists('id')->all();
        foreach(range(2, 6) as $index)
        {

            DB::table('role_user')->insert([
                'role_id' => $faker->randomElement($rolesIds),
                'user_id' => $index
            ]);

        }


    }

}