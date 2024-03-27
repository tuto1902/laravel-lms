<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $withCount = [
        'episodes'
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('sort');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function formattedLength(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                if (! isset($this->episodes_sum_length_in_minutes)) {
                    $this->loadSum('episodes', 'length_in_minutes');
                }
                $totalMinutes = $this->episodes_sum_length_in_minutes;
                $hours = floor($totalMinutes/60);
                $hoursString = $hours > 0 ? $hours . ' ' . Str::plural('hr', $hours) . ' ' : '';
                $reminderMinutes = $totalMinutes % 60;
                $minutesString = $reminderMinutes . ' ' . Str::plural('min', $reminderMinutes);

                return $hoursString . $minutesString;
            }
        );
    }
}
