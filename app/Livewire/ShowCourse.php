<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Episode;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowCourse extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->course->loadCount('episodes');
    }

    public function courseInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->course)
            ->schema([
                Infolists\Components\Section::make()
                    ->schema([
                        InfoLists\Components\TextEntry::make('tags.name')
                            ->hiddenLabel()
                            ->badge(),
                        Infolists\Components\TextEntry::make('title')
                            ->hiddenLabel()
                            ->size('text-4xl')
                            ->weight('font-bold')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('tagline')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                        Infolists\Components\Fieldset::make('')
                            ->columns(3)
                            ->columnSpan(1)
                            ->schema([
                                Infolists\Components\TextEntry::make('episodes_count')
                                    ->hiddenLabel()
                                    ->formatStateUsing(fn ($state) => "$state episodes")
                                    ->icon('heroicon-o-film'),
                                Infolists\Components\TextEntry::make('formatted_length')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-clock'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->hiddenLabel()
                                    //->date('M d, Y')
                                    ->formatStateUsing(fn ($state) => $state->diffForHumans())
                                    ->icon('heroicon-o-calendar'),
                            ])
                            ->extraAttributes(['class' => 'border-none !p-0']),
                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('watch')
                                    ->label(fn (Course $record) => auth()->user()?->courses->contains($record) ? 'Continue Watching' : 'Start Watching')
                                    ->button()
                                    ->icon('heroicon-o-play-circle')
                                    ->action(fn (Course $record) => $this->redirectRoute('courses.episodes.show', ['course' => $record]))
                        ])
                        ->columnSpanFull()
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('About this course')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpan(2),
                        Infolists\Components\RepeatableEntry::make('episodes')
                            ->schema([
                                Infolists\Components\TextEntry::make('title')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-play-circle')
                                    ->url(fn (Episode $record) => route('courses.episodes.show', ['course' => $record->course->getRouteKey(), 'episode' => $record->getRouteKey()])),
                                Infolists\Components\TextEntry::make('formatted_length')
                                    ->hiddenLabel()
                                    ->icon('heroicon-o-clock'),
                            ])
                            ->columns(2),
                    ])
            ]);
    }

    public function render()
    {
        return view('livewire.show-course');
    }
}
