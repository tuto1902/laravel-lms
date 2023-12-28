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

it('has the course length', function () {
    $courseA = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 150]), 'episodes')
        ->create();

    $courseB = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 61]), 'episodes')
        ->create();

    $courseC = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();

    expect($courseA->formatted_length)
        ->toBe('2 hrs 30 mins');
    expect($courseB->formatted_length)
        ->toBe('1 hr 1 min');
    expect($courseC->formatted_length)
        ->toBe('0 mins');
});