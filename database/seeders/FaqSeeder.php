<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Airway connect?',
                'answer' => 'It is a project comprising automated systems. You can schedule, plan, and introduce your upcoming plans.'
            ],
            [
                'question' => 'How is the team Airway connect?',
                'answer' => 'The team works together to execute process functions and provide the latest results.'
            ],
            [
                'question' => 'What does the Airway connect work?',
                'answer' => 'You can also train for or request to execute a process function path with your own latest results.'
            ],
            [
                'question' => 'How often will I get team Airway connect?',
                'answer' => 'It is close to newsletter regular updates.'
            ],
            [
                'question' => 'How automated is this?',
                'answer' => 'The system comprises automated features for scheduling and planning.'
            ],
        ];

        foreach ($faqs as $data) {
            FAQ::updateOrCreate(
                [
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ],
                ['status' => 1]
            );
        }
    }
}
