<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Meal;
use function Laravel\Prompts\table;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(Meal::factory()->count(1))
            ->count(10)
            ->create();

        $meals = Meal::all();

        User::all()->each(function ($user) use ($meals) {
           $user->favorites()->attach($meals->random(3)->pluck('id')->toArray()); //future me deal with double user faving the same things twice
                                                                                                 //past me no
        });
    }
}
