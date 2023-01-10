<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesAndServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$family = Category::create(['name' => 'Family']);
        $home = Category::create(['name' => 'Home']);
        $pearson = Category::create(['name' => 'Pearson']);
        $animals = Category::create(['name' => 'Animals']);
        $lessons = Category::create(['name' => 'Lessons']);
        $professionals = Category::create(['name' => 'Professionals']);
        $eventsAndParty = Category::create(['name' => 'EventsAndParty']);
        $repairingObjects = Category::create(['name' => 'RepairingObjects']);
        $health = Category::create(['name' => 'Health']);*/

        $babySitter = SubCategory::create(['name' => 'babySitter', 'category_name' => 'Family']);
        $driver = SubCategory::create(['name' => 'driver', 'category_name' => 'Family']);
    }
}
