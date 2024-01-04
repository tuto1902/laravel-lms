<?php

use App\Livewire\WatchEpisode;
use App\Models\Course;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('renders successfully', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['vimeo_id' => '123456789']), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertStatus(200);
});

it('shows the first episode if none is provided', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory(2)->state(new Sequence(
            ['overview' => 'First episode overview'],
            ['overview' => 'Second episode overview'],
        )), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText($course->episodes->first()->overview);
});

it('shows the provided episode', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory(2)->state(new Sequence(
            ['overview' => 'First episode overview'],
            ['overview' => 'Second episode overview'],
        )), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course, 'episode' => $course->episodes->last()])
        ->assertOk()
        ->assertSeeText('Second episode overview');
});
