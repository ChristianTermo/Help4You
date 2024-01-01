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

        
        
        $professionals = Category::create(['name' => 'Professionals']);
        $eventsAndParty = Category::create(['name' => 'EventsAndParty']);
        $repairingObjects = Category::create(['name' => 'RepairingObjects']);
        $health = Category::create(['name' => 'Health']);

        $family = Category::create(['name' => 'Family']);
        $babySitter = Category::create(['name' => 'babySitter',  'father_id' => '1']);
        $driver = Category::create(['name' => 'driver',  'father_id' => '1']);
        $care_giver = Category::create(['name' => 'care_giver',  'father_id' => '1']);
        $laundry_and_ironing  = Category::create(['name' => 'laundry and ironing ',  'father_id' => '1']);
        $cleaning_service = Category::create(['name' => 'cleaning service',  'father_id' => '1']);
        $tailor = Category::create(['name' => 'tailor',  'father_id' => '1']);
        $mover = Category::create(['name' => 'mover',  'father_id' => '1']);
        $roadside_assistance = Category::create(['name' => 'roadside assistance',  'father_id' => '1']);
        $home_cooking = Category::create(['name' => 'home cooking',  'father_id' => '1']);

        $home = Category::create(['name' => 'Home']);
        $handyman = Category::create(['name' => 'handyman',  'father_id' => '21']);
        $hydraulic = Category::create(['name' => 'hydraulic',  'father_id' => '21']);
        $electrycian = Category::create(['name' => 'electrycian',  'father_id' => '21']);
        $painter = Category::create(['name' => 'painter',  'father_id' => '21']);
        $gardener = Category::create(['name' => 'gardener',  'father_id' => '21']);
        $security_system = Category::create(['name' => 'security system',  'father_id' => '21']);
        $antennist = Category::create(['name' => 'antennist',  'father_id' => '21']);
        $mason = Category::create(['name' => 'mason',  'father_id' => '21']);
        $carpenter = Category::create(['name' => 'carpenter',  'father_id' => '21']);
        $restorer = Category::create(['name' => 'restorer',  'father_id' => '21']);
        $furniture_assembly = Category::create(['name' => 'furniture assembly',  'father_id' => '21']);
        $disposal_of_objects = Category::create(['name' => 'disposal of objects',  'father_id' => '21']);
        $disinfection = Category::create(['name' => 'disinfection',  'father_id' => '21']);
        $chimney_sweep = category::create(['name' => 'chimney sweep',  'father_id' => '21']);
        $blacksmith = category::create(['name' => ' blacksmith',  'father_id' => '21']);
        $carpenter = category::create(['name' => 'carpenter',  'father_id' => '21']);
        $decorator = Category::create(['name' => 'decorator',  'father_id' => '21']);
        $tinsmith = Category::create(['name' => 'tinsmith',  'father_id' => '21']);
        $glass_and_fixtures = Category::create(['name' => 'glass and fixtures',  'father_id' => '21']);

        $pearson = Category::create(['name' => 'Pearson']);
        $hairdresser = Category::create(['name' => 'hairdresser',  'father_id' => '81']);
        $esthetician = Category::create(['name' => 'esthetician',  'father_id' => '81']);
        $makeup = Category::create(['name' => 'makeup',  'father_id' => '81']);
        $manicure_pedicure = Category::create(['name' => 'manicure & pedicure',  'father_id' => '81']);
        $nutritionist = Category::create(['name' => 'nutritionist',  'father_id' => '81']);
        $massager = Category::create(['name' => 'massager',  'father_id' => '81']);
        $personal_trainer = Category::create(['name' => 'personal trainer',  'father_id' => '81']);
        $personal_shopper = Category::create(['name' => 'personal shopper',  'father_id' => '81']);
        $speech_terapist = Category::create(['name' => 'speech terapist',  'father_id' => '81']);
        $tatoo_piercing = Category::create(['name' => 'tatoo & piercing',  'father_id' => '81']);
        $yoga = Category::create(['name' => 'yoga',  'father_id' => '81']);

        $animals = Category::create(['name' => 'Animals']);
        $veterinarian = Category::create(['name' => 'veterinarian',  'father_id' => '105']);
        $petsitter = Category::create(['name' => 'petsitter',  'father_id' => '105']);
        $pets_toilette = Category::create(['name' => 'pets toilette',  'father_id' => '105']);
        $lessons = Category::create(['name' => 'Lessons']);
        $subjects = Category::create(['name' => 'subjects',  'father_id' => '109']);
        $math = Category::create(['name' => 'math',  'father_id' => '110']);
        $science = Category::create(['name' => 'science',  'father_id' => '110']);
        $economic = Category::create(['name' => 'economic',  'father_id' => '110']);
        $physic = Category::create(['name' => 'physic',  'father_id' => '110']);
        $chemistry = Category::create(['name' => 'chemistry',  'father_id' => '110']);
        $statistic = Category::create(['name' => 'statistic',  'father_id' => '110']);
        $biology = Category::create(['name' => 'biology',  'father_id' => '110']);
        $computer_science = Category::create(['name' => 'computer science',  'father_id' => '110']);
        $history = Category::create(['name' => 'history',  'father_id' => '110']);
        $latin = Category::create(['name' => 'latin',  'father_id' => '110']);
        $greek = Category::create(['name' => 'greek',  'father_id' => '110']);
        $italian = Category::create(['name' => 'italian',  'father_id' => '110']);
        $primary_subjects = Category::create(['name' => 'primary subjects',  'father_id' => '110']);

     /* id 124*/  $art_music = Category::create(['name' => 'art & music',  'father_id' => '109']);

    }
}
