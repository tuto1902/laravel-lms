<?php

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\get;

it('has a route for the course details page', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();

    get(route('courses.show', ['course' => $course]))
        ->assertOk();
});
