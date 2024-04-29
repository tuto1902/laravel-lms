<?php

use App\Livewire\CourseList;
use App\Models\Course;
use App\Models\Episode;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('renders successfully', function () {
    Livewire::test(CourseList::class)
        ->assertStatus(200);
});

it('shows a list of all courses', function() {
    Course::factory(3)
        ->state(new Sequence(
            ['title' => 'Course A'],
            ['title' => 'Course B'],
            ['title' => 'Course C'],
        ))
        ->has(Episode::factory()->state(['length_in_minutes' => 10]), 'episodes')
        ->create();

    Livewire::test(CourseList::class)
        ->assertSeeText(
            'Course A',
            'Course B',
            'Course C'
        );
});

it('shows the course tags', function() {
    $course = Course::factory()
        ->has(Episode::factory())
        ->has(
            Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'Bootstrap'],
                    ['name' => 'AlpineJS'],
                ))
        )
        ->create();
    $user = User::factory()->create();
    $user->courses()->attach($course);

    Livewire::test(CourseList::class)
        ->assertOk()
        ->assertSeeText([
            'Bootstrap',
            'AlpineJS'
        ]);
});

it('can be filter with tags name', function () {

    $filament = Course::factory()
        ->has(Episode::factory())
        ->has(Tag::factory()->count(2))
        ->create();

     $course = Course::factory()
        ->has(Episode::factory())
        ->has(
            Tag::factory()
                ->state(new Sequence(
                    ['name' => 'Vue'],
                ))
        )
        ->create();


    Livewire::test(CourseList::class)
        ->assertOk()
        ->assertCanSeeTableRecords(Course::get())
        ->filterTable('tags',$course->tags()->pluck('tag_id')->toArray())
        ->assertCanSeeTableRecords(Course::whereRelation('tags','tag_id',$course->tags->first()->id)->get())
        ->assertCanNotSeeTableRecords(Course::whereRelation('tags','tag_id','<>',$course->tags->first()->id)->get());

});



