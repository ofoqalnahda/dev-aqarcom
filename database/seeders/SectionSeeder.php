<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            'about_app' => ['about.png'],
            'support_services' => ['message.png','message.png','message.png','message.png','message.png','message.png'],
            'our_vision'=> ['message.png'],
            'our_message'=> ['message.png'],
            'app_features' => ['about.png'],
            'pre_purchase_services'=> ['message.png'],
            'post_purchase_services'=> ['message.png'],
            'after_sell_services'=> ['message.png'],
            'app_images'=> ['about.png'],
        ];

        foreach ($sections as $sectionName => $images){
            $section = Section::create([
                'section_name' => $sectionName
            ]);

            foreach ($images as $image){
                $section->images()->create([
                    'image' => $image
                ]);
            }
        }
    }
}
