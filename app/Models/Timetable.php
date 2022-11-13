<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $day
 * @property string $hour
 * @property string $group
 * @property string $lesson
 * @property string $lecturer
 * @property string $lessonRoom
 * @property-read Specialization $specialization
 */

class Timetable extends Model
{
    use HasFactory;

    protected $table = "timetable";
    protected $fillable = [
        "day",
        "hour",
        "group",
        "lecturer",
        "lesson",
        "lesson_room",
    ];

    /**
     * @return BelongsTo<Specialization, Timetable>
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
