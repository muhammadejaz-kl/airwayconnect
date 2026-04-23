<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ForumTopicSeeder::class,
            LegalSeeder::class,
            FaqSeeder::class,
            ResumeSkillSeeder::class,
            SubscriptionSeeder::class,
            InterviewSeeder::class,
        ]);

    }
}
