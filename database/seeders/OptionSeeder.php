<?php
namespace Database\Seeders;

use App\Models\PollOption;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pollOption = [];

        for ($i = 1; $i <= 20; $i++) {
            $option = rand(2, 5);
            for ($j = 0; $j < $option; $j++) {
                $pollOption[] = [
                    'poll_id' => $i,
                    'option'  => fake()->sentence(3),
                ];
            }
        }

        PollOption::insert($pollOption);
    }
}
