<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Course;
use App\Models\Episode;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $course = Course::factory()
            ->state([
                'title' => 'Filament Bootcamp',
                'tagline' => 'Start creating your own Admin Panels today!',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis delectus eius commodi, ducimus est earum eos eligendi quaerat asperiores et ipsam molestias animi incidunt? Voluptas, ut! Deserunt amet libero possimus.'
            ])
            ->for(User::factory()->state([
                'name' => 'Instructor',
                'email' => 'instructor@example.com'
            ])->instructor(), 'instructor')
            ->has(Episode::factory(3)->state(new Sequence(
                [
                    'title' => 'Introduction',
                    'overview' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis delectus eius commodi, ducimus est earum eos eligendi quaerat asperiores et ipsam molestias animi incidunt? Voluptas, ut! Deserunt amet libero possimus.',
                    'vimeo_id' => '903495635',
                    'length_in_minutes' => 1,
                    'sort' => 1
                ],
                [
                    'title' => 'Tour',
                    'overview' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis delectus eius commodi, ducimus est earum eos eligendi quaerat asperiores et ipsam molestias animi incidunt? Voluptas, ut! Deserunt amet libero possimus.',
                    'vimeo_id' => '879276992',
                    'length_in_minutes' => 1,
                    'sort' => 2
                ],
                [
                    'title' => 'Installation',
                    'overview' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis delectus eius commodi, ducimus est earum eos eligendi quaerat asperiores et ipsam molestias animi incidunt? Voluptas, ut! Deserunt amet libero possimus.',
                    'vimeo_id' => '905849774',
                    'length_in_minutes' => 5,
                    'sort' => 3
                ],
            )), 'episodes')
            ->has(
                Tag::factory()
                    ->count(2)
                    ->state(new Sequence(
                        ['name' => 'Laravel'],
                        ['name' => 'Filament'],
                    ))
            )
        ->create();

        $user = User::factory()->create([
            'name' => 'Arturo',
            'email' => 'arturo@example.com',
        ]);

        $user->courses()->attach($course);
    }
}
