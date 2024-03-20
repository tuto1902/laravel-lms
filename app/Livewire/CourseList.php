<?php

namespace App\Livewire;

use App\Models\Course;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

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
                ])
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
