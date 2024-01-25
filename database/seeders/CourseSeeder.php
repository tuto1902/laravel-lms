<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory()
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
            ->create();
    }
}
