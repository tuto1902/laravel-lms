<?php

use App\Livewire\CourseList;
use App\Models\Course;
use App\Models\Episode;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

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
        ->has(
            Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'Bootstrap'],
                    ['name' => 'AlpineJS'],
                ))
        )
        ->create();

     Course::factory()
        ->has(Episode::factory())
        ->has(
            Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'Vue'],
                    ['name' => 'Tailwind'],
                ))
        )
        ->create();

    $firstCourseTagsIds = $filament->tags()->pluck('tag_id')->toArray();

    Livewire::test(CourseList::class)
        ->assertCanSeeTableRecords(Course::get())
        ->filterTable('tags',$firstCourseTagsIds)
        ->assertCanSeeTableRecords(Course::whereHas('tags',function ($q) use ($firstCourseTagsIds){
            $q->whereIn('tag_id',$firstCourseTagsIds);
        })->get())
        ->assertCanNotSeeTableRecords(Course::whereHas('tags',function ($q) use ($firstCourseTagsIds){
            $q->whereNotIn('tag_id',$firstCourseTagsIds);
        })->get())
        ->assertSeeText([
            'Bootstrap','AlpineJS'
        ])
        ->assertDontSeeText([
            'Tailwind','Vue'
        ]);

});


it('can be filter remove tags', function () {

    $filament = Course::factory()
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

    $vues = Course::factory()
        ->has(Episode::factory())
        ->has(
            Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name' => 'Vue'],
                ))
        )
        ->create();

    $filamentCourseTagsIds = $filament->tags()->pluck('tag_id')->toArray();
    $vuesCourseTagsIds = $vues->tags()->pluck('tag_id')->toArray();

    Livewire::test(CourseList::class)
        ->assertCanSeeTableRecords(Course::get())
        ->filterTable('tags',$vuesCourseTagsIds)
        ->assertCanNotSeeTableRecords(Course::whereHas('tags',function ($q) use ($filamentCourseTagsIds){
            $q->whereIn('tag_id',array_merge($filamentCourseTagsIds));
        })->get())
        ->assertSeeText([
            'Vue',
        ])->removeTableFilters()
        ->assertSeeText(['Bootstrap'])
        ->assertCanSeeTableRecords(Course::get());

});


it('can be reset the filter ', function () {

    $courses = Course::factory(2)
        ->has(Episode::factory())
        ->has(
            Tag::factory()
                ->count(2)
        )
        ->create();

    Livewire::test(CourseList::class)
        ->assertCanSeeTableRecords($courses)
        ->resetTableFilters();
});
