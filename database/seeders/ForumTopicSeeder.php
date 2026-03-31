<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumTopic;

class ForumTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            ['topic' => 'Airlines'],
            ['topic' => 'Aviation'],
            ['topic' => 'Travel'],
            ['topic' => 'Air Travel'],
            ['topic' => 'Pilot Life'],
            ['topic' => 'Flight Deals'],
            ['topic' => 'Airports'],
            ['topic' => 'Frequent Flyer'],
            ['topic' => 'Flight Training'],
        ];

        foreach ($topics as $data) {
            ForumTopic::updateOrCreate(
                ['topic' => $data['topic']],
                ['status' => 1]
            );
        }
    }
}
