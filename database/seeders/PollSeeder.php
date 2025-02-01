<?php
namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polls = [];

        for ($i = 0; $i < 20; $i++) {
            Poll::create([
                'user_id'           => rand(1, 10),
                'title'             => fake()->sentence(5),
                'description'       => fake()->sentence(10),
                'allow_multiple'    => rand(0, 1),
                'public_visibility' => rand(0, 1),
                'status'            => Arr::random(['active', 'inactive']),
                'expire_at'         => now()->addDays(rand(1, 3)),
            ]);

        }

        Poll::insert($polls);
    }
}
