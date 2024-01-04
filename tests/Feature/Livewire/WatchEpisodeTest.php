<?php

use Illuminate\Database\Eloquent\Factories\Sequence;

// it('renders successfully', function () {
//     $course = Course::factory()
//         ->for(User::factory()->instructor(), 'instructor')
//         ->has(Episode::factory()->state(['vimeo_id' => '123456789']), 'episodes')
//         ->create();

//     Livewire::test(WatchEpisode::class, ['course' => $course])
//         ->assertStatus(200);
// });

// it('shows the first episode if none is provided', function () {
//     $course = Course::factory()
//         ->for(User::factory()->instructor(), 'instructor')
//         ->has(Episode::factory()->state(['vimeo_id' => '123456789']), 'episodes')
//         ->create();

//     Livewire::test(WatchEpisode::class, ['course' => $course])
//         ->assertOk()
//         ->assertSeeText($course->episodes->first()->overview);
// });

// it('shows the provided episode', function () {
//     $course = Course::factory()
//         ->for(User::factory()->instructor(), 'instructor')
//         ->has(Episode::factory(2)->state(new Sequence(
//             ['overview' => 'First episode overview', 'vimeo_id' => '123456789'],
//             ['overview' => 'Second episode overview', 'vimeo_id' => '987654321'],
//         )), 'episodes')
//         ->create();

//     Livewire::test(WatchEpisode::class, ['course' => $course, 'episode' => $course->episodes->last()])
//         ->assertOk()
//         ->assertSeeText('Second episode overview');
// });
