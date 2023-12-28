<?php

use App\Livewire\ShowCourse;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

it('renders successfully', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 10])->count(10), 'episodes')
        ->create();
    
    Livewire::test(ShowCourse::class, ['course' => $course])
        ->assertStatus(200);
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 10])->count(10), 'episodes')
        ->create();

    // Act & Assert
    Livewire::test(ShowCourse::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText($course->title)
        ->assertSeeText($course->tagline)
        ->assertSeeText($course->description)
        ->assertSeeText($course->instructor->name)
        ->assertSeeText($course->created_at->format('M d, Y'))
        ->assertSeeText($course->episodes_count . ' episodes')
        ->assertSeeText($course->formatted_length);
});

it('shows the episode list', function () {
    // Arrange
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(
            Episode::factory()
                ->count(3)
                ->state(new Sequence(
                    ['title' => 'First Episode', 'length_in_minutes' => 5],
                    ['title' => 'Second Episode', 'length_in_minutes' => 10],
                    ['title' => 'Third Episode', 'length_in_minutes' => 1],
                ))
        )
        ->create();

    Livewire::test(ShowCourse::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText('First Episode')
        ->assertSeeText('5 mins')
        ->assertSeeText('Second Episode')
        ->assertSeeText('10 mins')
        ->assertSeeText('Third Episode')
        ->assertSeeText('1 min');
});
