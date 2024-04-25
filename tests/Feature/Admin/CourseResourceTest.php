<?php

use App\Filament\Resources\CourseResource;
use App\Models\Course;
use App\Models\Episode;
use App\Models\Tag;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteAction as TableDeleteAction;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->state(['email' => 'arturo@example.com'])->create());
});

it('renders the resource page', function () {   
    get(CourseResource::getUrl())
        ->assertOk();
});

it('can list courses', function () {
    $courses = Course::factory(3)
        ->has(Episode::factory(), 'episodes')
        ->create();

    Livewire::test(CourseResource\Pages\ListCourses::class)
        ->assertCanSeeTableRecords($courses);
});

it('renders the create page', function () {
    get(CourseResource::getUrl('create'))
        ->assertOk();
});

it('can create a course', function () {
    $newCourse = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->has(Tag::factory(3))
        ->make();

    Livewire::test(CourseResource\Pages\CreateCourse::class)
        ->fillForm([
            'title' => $newCourse->title,
            'description' => $newCourse->description,
            'tagline' => $newCourse->tagline,
            'tags' => json_encode($newCourse->tags)
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas('courses', [
        'title' => $newCourse->title,
        'description' => $newCourse->description,
        'tagline' => $newCourse->tagline,
    ]);
});

it('renders the edit page', function () {
    $course = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->create();

    get(CourseResource::getUrl('edit', ['record' => $course]))
        ->assertOk();
});

it('can update a course', function () {
    $course = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->has(Tag::factory(3))
        ->create();

    $newCourse = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->has(Tag::factory(3))
        ->make();
 
    Livewire::test(CourseResource\Pages\EditCourse::class, [
        'record' => $course->getRouteKey(),
    ])
    ->fillForm([
        'title' => $newCourse->title,
        'description' => $newCourse->description,
        'tagline' => $newCourse->tagline,
        'tags' => json_encode($newCourse->tags)
    ])
    ->call('save')
    ->assertHasNoFormErrors();
 
    expect($course->refresh())
        ->title->toBe($newCourse->title)
        ->description->toBe($newCourse->description)
        ->tagline->toBe($newCourse->tagline);
});

it('can delete a course from the edit page', function () {
    $course = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->create();
 
    Livewire::test(CourseResource\Pages\EditCourse::class, [
        'record' => $course->getRouteKey(),
    ])
    ->callAction(DeleteAction::class);
 
    assertModelMissing($course);
});

it('can delete a course from the list page', function () {
    $course = Course::factory()
        ->has(Episode::factory(), 'episodes')
        ->create();
 
    Livewire::test(CourseResource\Pages\ListCourses::class)
        ->callTableAction(TableDeleteAction::class, $course);
 
    assertModelMissing($course);
});

it('can render episodes relation manager', function () {
    $course = Course::factory()
        ->has(Episode::factory(3), 'episodes')
        ->create();
 
    Livewire::test(CourseResource\RelationManagers\EpisodesRelationManager::class, [
        'ownerRecord' => $course,
        'pageClass' => EditCourse::class,
    ])
    ->assertSuccessful();
});