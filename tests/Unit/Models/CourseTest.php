<?php

use App\Models\Course;
use App\Models\User;

it('has an instructor relationship', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();

    expect($course->instructor)
        ->toBeInstanceOf(User::class)
        ->is_instructor->toBeTrue();
});
