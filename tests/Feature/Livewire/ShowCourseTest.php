<?php

use App\Livewire\ShowCourse;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowCourse::class)
        ->assertStatus(200);
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->count(10), 'episodes')
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
        ->assertSeeText($course->episodes_duration_sum);
});
