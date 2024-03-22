<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Coach;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $coaches = $users->random(5)->map(fn(User $user) => Coach::factory()->create([
            "user_id" => $user->id
        ]));

        $this->call([
            CollectionSeeder::class
        ]);
    }
}
