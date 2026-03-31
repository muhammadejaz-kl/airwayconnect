<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Club Member',
                'validity' => '1_month',
                'amount' => '12.00',
                'features' => '["Classroom","Jobs","Resource Library","Forum"]',
                'status' => '1',

            ]
        ];

        foreach ($users as $data) {
            $user = Subscription::updateOrCreate(
                [
                    'name' => $data['name'],
                    'validity' => $data['validity'],
                    'amount' => $data['amount'],
                    'features' => $data['features'],
                    'status' => $data['status']
                ]
            );
        }
    }
}
