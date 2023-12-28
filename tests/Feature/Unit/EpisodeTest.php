<?php

use App\Models\Course;
use App\Models\Episode;
use App\Models\User;

it('has the episode length', function () {
    $episode = Episode::factory(['length_in_minutes' => 5])
        ->for(Course::factory()->for(User::factory()->instructor(), 'instructor'))
        ->create();

    expect($episode->formatted_length)->toBe('5 mins');
});
