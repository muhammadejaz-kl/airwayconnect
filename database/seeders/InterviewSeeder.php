<?php

namespace Database\Seeders;

use App\Models\InterviewQuestionAnswer;
use App\Models\InterviewTopic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/qna_output.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        // Clear existing data (disable FK checks first)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        InterviewQuestionAnswer::truncate();
        InterviewTopic::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Insert "ALL TOPICS" as first topic (special)
        $allTopics = InterviewTopic::create([
            'topic'       => 'ALL TOPICS',
            'description' => 'All topics combined',
            'status'      => 1,
        ]);

        // Track topic DB IDs for "ALL TOPICS" Q&A insertion later
        $allQna = [];

        foreach ($data as $topicData) {
            $topic = InterviewTopic::create([
                'topic'       => $topicData['name'],
                'description' => $topicData['name'],
                'status'      => 1,
            ]);

            foreach ($topicData['qna'] as $qna) {
                if (empty($qna['question'])) {
                    continue;
                }

                $questionImage = null;
                $answerImage   = null;

                if (!empty($qna['images'])) {
                    foreach ($qna['images'] as $img) {
                        if ($img['type'] === 'question' && $questionImage === null) {
                            $questionImage = $img['url'];
                        }
                        if ($img['type'] === 'answer' && $answerImage === null) {
                            $answerImage = $img['url'];
                        }
                    }
                }

                $record = InterviewQuestionAnswer::create([
                    'topic_id'       => $topic->id,
                    'type'           => 'QA',
                    'question'       => $qna['question'],
                    'question_image' => $questionImage,
                    'answer'         => $qna['answer'] ?? '',
                    'answer_image'   => $answerImage,
                    'status'         => 1,
                ]);

                $allQna[] = [
                    'topic_id'       => $allTopics->id,
                    'type'           => 'QA',
                    'question'       => $qna['question'],
                    'question_image' => $questionImage,
                    'answer'         => $qna['answer'] ?? '',
                    'answer_image'   => $answerImage,
                    'status'         => 1,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        // Bulk insert ALL TOPICS Q&A in chunks to avoid memory issues
        foreach (array_chunk($allQna, 500) as $chunk) {
            InterviewQuestionAnswer::insert($chunk);
        }

        $this->command->info('Interview topics and Q&A seeded successfully!');
        $this->command->info('Topics: ' . InterviewTopic::count());
        $this->command->info('Q&A records: ' . InterviewQuestionAnswer::count());
    }
}
