<?php

use App\Livewire\ShowCourse;
use App\Models\Course;
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
        ->create();

    // Act & Assert
    Livewire::test(ShowCourse::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText($course->title)
        ->assertSeeText($course->tagline)
        ->assertSeeText($course->description)
        ->assertSeeText($course->instructor->name)
        ->assertSeeText('Dec 06, 2023');
});
