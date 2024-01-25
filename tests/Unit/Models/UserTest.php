<?php

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('has many courses', function () {
    $user = User::factory()->create();
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();

    $user->courses()->attach($course);

    expect($user->courses)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(Course::class)
        ->first()->title->toBe($course->title);
});

it('has many watched episodes', function () {
    $user = User::factory()->create();
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();
    $episode = Episode::factory()->for($course)->create();

    $user->watchedEpisodes()->attach($episode);

    expect($user->watchedEpisodes)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(Episode::class)
        ->first()->title->toBe($episode->title);
});
