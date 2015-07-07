<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use App\Category;
use App\Product;
use Illuminate\Database\Seeder;


class CategoriesProductsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $categoriesIds = Category::lists('id')->all();
        $ProductsIds = Product::lists('id')->all();
        foreach(range(1, Product::count()) as $index)
        {

            DB::table('category_product')->insert([
                'category_id' => $faker->randomElement($categoriesIds),
                'product_id' => $index,
            ]);

        }


    }

}