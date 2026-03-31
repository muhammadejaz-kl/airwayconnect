<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\SkillCategory;

class ResumeSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Pilot',
            'Flight Attendants',
            'Ground Staff',
            'Aircraft Maintenance Engineers',
            'Administrative Roles'
        ];

        $skill = [
            'Pilot' => ['Navigation', 'Aircraft Operation', 'Safety Procedures', 'Communication'],
            'Flight Attendants' => ['Customer Service', 'Emergency Handling', 'Multilingual', 'In-flight Service'],
            'Ground Staff' => ['Baggage Handling', 'Check-in Management', 'Passenger Assistance', 'Coordination'],
            'Aircraft Maintenance Engineers' => ['Engine Diagnostics', 'Electrical Systems', 'Hydraulics', 'Routine Checks'],
            'Administrative Roles' => ['Scheduling', 'Record Keeping', 'Communication Skills', 'Problem Solving']
        ];

        foreach ($categories as $categoryName) { 
            $category = SkillCategory::create([
                'name' => $categoryName
            ]);
 
            $skills = $skill[$categoryName] ?? [];

            foreach ($skills as $skillName) {
                Skill::create([
                    'category_id' => $category->id,
                    'skill' => $skillName
                ]);
            }
        }
    }
}
