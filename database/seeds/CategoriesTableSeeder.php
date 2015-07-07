<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use App\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;



class CategoriesTableSeeder extends Seeder {

    /**
     *
     */
    public function run()
    {


        factory(Category::class, 5)->create();



    }
}