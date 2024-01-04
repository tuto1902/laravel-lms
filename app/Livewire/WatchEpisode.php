<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Episode;
use Livewire\Component;

class WatchEpisode extends Component
{
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

    public function render()
    {
        return view('livewire.watch-episode');
    }
}
