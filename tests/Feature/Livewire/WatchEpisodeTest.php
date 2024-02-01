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

    $user = User::factory()->create();
    $user->courses()->attach($course);

    Livewire::actingAs($user)->test(WatchEpisode::class, ['course' => $course])
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
            ['overview' => 'First episode overview', 'sort' => 1],
            ['overview' => 'Second episode overview', 'sort' => 2],
        )), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course, 'episode' => $course->episodes->last()])
        ->assertOk()
        ->assertSeeText('Second episode overview');
});

it('shows the list of episodes', function() {
    // Arrange
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(
            Episode::factory()
                ->count(3)
                ->state(new Sequence(
                    ['title' => 'First Episode', 'sort' => 1],
                    ['title' => 'Second Episode', 'sort' => 2],
                    ['title' => 'Third Episode', 'sort' => 3],
                ))
        )
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertOk()
        ->assertSeeInOrder([
            'First Episode',
            'Second Episode',
            'Third Episode'
        ]);
});

it('shows the video player', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory()->state(['vimeo_id' => '123456789']), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertOk()
        ->assertSee('<iframe src="https://player.vimeo.com/video/123456789"', false);
});

it('shows the list of episodes in ascending order', function() {
    // Arrange
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(
            Episode::factory()
                ->count(3)
                ->state(new Sequence(
                    ['title' => 'Second Episode', 'sort' => 2],
                    ['title' => 'Third Episode', 'sort' => 3],
                    ['title' => 'First Episode', 'sort' => 1],
                ))
        )
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertOk()
        ->assertSeeInOrder([
            'First Episode',
            'Second Episode',
            'Third Episode'
        ]);
});

it('redirect to next episode after video ends', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory(2)->state(new Sequence(
            ['overview' => 'First episode overview', 'sort' => 1],
            ['overview' => 'Second episode overview', 'sort' => 2],
        )), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course])
        ->assertOk()
        ->assertSeeText('First episode overview')
        ->dispatch('episode-ended', $course->episodes->first()->getRouteKey())
        ->assertSeeText('Second episode overview');
});

it('stays in the the last episode after video ends', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory(2)->state(new Sequence(
            ['overview' => 'First episode overview', 'sort' => 1],
            ['overview' => 'Second episode overview', 'sort' => 2],
        )), 'episodes')
        ->create();

    Livewire::test(WatchEpisode::class, ['course' => $course, 'episode' => $course->episodes->last()->getRouteKey()])
        ->assertOk()
        ->dispatch('episode-ended', $course->episodes->last()->getRouteKey())
        ->assertSeeText('Second episode overview');
});

it('forbids showing episodes to users that do not own course', function () {
    $course = Course::factory()
        ->for(User::factory()->instructor(), 'instructor')
        ->has(Episode::factory())
        ->create();
    $user = User::factory()->create();
    $stranger = User::factory()->create();

    $user->courses()->attach($user);

    Livewire::actingAs($stranger)->test(WatchEpisode::class, ['course' => $course])
        ->assertForbidden();
});
