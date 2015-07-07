<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Illuminate\Database\Seeder;
use App\Tag;


class TagsTableSeeder extends Seeder {

    /**
     *
     */
    public function run()
    {
        factory(Tag::class, 10)->create();

    }
}