<?php

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('has a route for the course details page', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->create();
    
    actingAs(User::factory()->create());

    get(route('courses.show', ['course' => $course]))
        ->assertOk();
});

it('has a route for the watch episodes page with optional episode parameter', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['vimeo_id' => '123456789']), 'episodes')
        ->create();
    
    $user = User::factory()->create();
    $user->courses()->attach($course);
    
    actingAs($user);

    get(route('courses.episodes.show', ['course' => $course, 'episode' => $course->episodes->first()]))
        ->assertOk();

    get(route('courses.episodes.show', ['course' => $course]))
        ->assertOk();
});

it('it only shows episodes to authenticated users', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory(), 'episodes')
        ->create();

    get(route('courses.episodes.show', ['course' => $course]))
        ->assertRedirect(route('login'));
});
