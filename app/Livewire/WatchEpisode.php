<?php

namespace App\Livewire;

use App\Infolists\Components\VideoPlayerEntry;
use App\Models\Course;
use App\Models\Episode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Livewire\Component;

class WatchEpisode extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;
    public Episode $currentEpisode;

    public function mount(Course $course, Episode $episode)
    {
        $this->course = $course;
        
        if (isset($episode->id)) {
            $this->currentEpisode = $episode;
        } else {
            $this->currentEpisode = $course->episodes->first();
        }
    }

    public function episodeInfolist (Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->currentEpisode)
            ->schema([
                VideoPlayerEntry::make('vimeo_id')
                    ->hiddenLabel(),
                Infolists\Components\TextEntry::make('overview'),
                Infolists\Components\RepeatableEntry::make('course.episodes')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->hiddenLabel()
                            ->icon('heroicon-o-play-circle'),
                        Infolists\Components\TextEntry::make('formatted_length')
                            ->hiddenLabel()
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2),
            ]);
    }

    public function render()
    {
        return view('livewire.watch-episode');
    }
}
