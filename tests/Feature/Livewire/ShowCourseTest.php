<?php

use App\Livewire\ShowCourse;
use App\Models\Course;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowCourse::class)
        ->assertStatus(200);
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()
        ->create();

    // Act & Assert
    Livewire::test(ShowCourse::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText($course->title)
        ->assertSeeText($course->tagline);
});
