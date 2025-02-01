<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'username'       => 'user' . $i,
                'email'          => fake()->unique()->safeEmail(),
                'password'       => bcrypt('password'),
                'email_verified' => fake()->numberBetween(0, 1),
            ];
        }

        User::insert($users);
    }
}
