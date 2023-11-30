<?php

use App\Models\Course;

use function Pest\Laravel\get;

it('has a route for the course details page', function () {
    $course = Course::factory()->create();

    get(route('courses.show', ['course' => $course]))
        ->assertOk();
});
