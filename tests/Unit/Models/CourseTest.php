<?php

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('belongs to an instructor', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();

    expect($course->instructor)
        ->toBeInstanceOf(User::class)
        ->is_instructor->toBeTrue();
});

it('has many episodes', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->count(10), 'episodes')
        ->create();

    expect($course->episodes)
        ->toBeInstanceOf(Collection::class)
        ->toHaveLength(10)
        ->each->toBeInstanceOf(Episode::class);
});

it('has the episodes count', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->count(10), 'episodes')
        ->create();
    
    $course->loadCount('episodes');

    expect($course->episodes_count)->toBe(10);
});
