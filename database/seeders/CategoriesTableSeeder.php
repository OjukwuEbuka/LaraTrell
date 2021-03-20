<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Ideas', 'On going', 'Completed'];

        foreach($categories as $category){
            Category::create(['name' => $category]);
        }
    }
}
