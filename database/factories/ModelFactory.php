<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Illuminate\Support\Str;

$factory->define(App\User::class, function ($faker) {
    return [
        'username' => $faker->word,
        'email' => $faker->email,
        'password' => bcrypt("123456"),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Role::class, function ($faker) {
    return [
        'name' => 'administrator',
    ];
});
$factory->define(App\Tag::class, function ($faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Profile::class, function ($faker) {
    return [
        'user_id'     => 1,
        'first_name'=> $faker->word,
        'last_name'=> $faker->word,
        'ide'=> $faker->randomNumber(),
        'address'=> $faker->address,
        'telephone'=> $faker->phoneNumber,
        'telephone2'=> $faker->phoneNumber,
        'city'=> $faker->city
    ];
});
$factory->define(App\Product::class, function ($faker) {
    return [
        'name'        => $faker->word,
        'slug'        => Str::slug($faker->word),
        'description' => $faker->text(),
        'price'       => 100,
        'published'   => 1,
        'featured'    => 1
    ];
});
$factory->define(App\Category::class, function ($faker) {
    return [
        'name'        => $faker->word,
        'slug'        => Str::slug($faker->word),
        'description' => $faker->text(),
        'published'   => 1,
        'featured'    => 0,
    ];
});
$factory->define(App\Option::class, function ($faker) {
    return [
        'name'        => $faker->word,
        'price'   => 100,
        'description' => $faker->text(),
    ];
});

