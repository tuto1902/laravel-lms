<?php

namespace App\Livewire;

use App\Models\Course;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Str;

class CourseList extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public Collection $courses;

    public function mount()
    {
        $this->courses = Course::all();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Course::query())
            ->contentGrid([
                'md' => 2,
                'lg' => 3
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('title')
                        ->weight('font-bold')
                        ->color('gray'),
                    Tables\Columns\TextColumn::make('tagline')
                        ->size('text-xs')
                        ->color('gray'),
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\IconColumn::make('episodes_count')
                            ->icon('heroicon-o-film')
                            ->size('w-4 h-4')
                            ->grow(false),
                        Tables\Columns\TextColumn::make('episodes_count')
                            ->formatStateUsing(fn ($state) => $state . ' ' . Str::plural('episode', $state))
                            ->size('text-[0.7rem]')
                            ->color('gray'),
                        Tables\Columns\IconColumn::make('formatted_length')
                            ->icon('heroicon-o-clock')
                            ->size('w-4 h-4')
                            ->grow(false),
                        Tables\Columns\TextColumn::make('formatted_length')
                            ->size('text-[0.7rem]')
                            ->color('gray'),
                    ])
                ])->space(3)
            ])
            ->actions([
                Tables\Actions\Action::make('Start Watching')
                    ->url(fn (Course $record): string => route('courses.show', ['course' => $record]))
                    ->button()
                    ->icon('heroicon-o-play-circle')
                    ->iconPosition(IconPosition::After)
            ]);
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate(($this->getTableRecordsPerPage() === 'all') ? $query->count() : $this->getTableRecordsPerPage());
    }

    public function render()
    {
        return view('livewire.course-list');
    }
}
