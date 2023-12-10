<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Number;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createNumbers();

        Participant::factory(2)->create();
    }

    private function createNumbers(): void
    {
        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            Number::create();
        }
    }
}
