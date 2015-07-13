<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'users','profiles', 'roles','role_user','categories','products','category_product','product_tag','tags','photos','options'
    ];
    private $seeders = [
        'UsersTableSeeder','RolesTableSeeder','ProfilesTableSeeder',
        'UsersRolesTableSeeder','TagsTableSeeder','ProductsTableSeeder',
        'CategoriesTableSeeder','CategoriesProductsTableSeeder','OptionsTableSeeder'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        Model::unguard();

        foreach ($this->seeders as $seederClass) {
            $this->call($seederClass);
        }

        Model::reguard();
    }
    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $tablename) {
            DB::table($tablename)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
