<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $day
 * @property string $hour
 * @property string $group
 * @property string $lesson
 * @property string $lecturer
 * @property string $lessonRoom
 * @property-read Specialization $specialization
 * @property-read Legend|null $legend
 */

class Timetable extends Model
{
    use HasFactory;

    protected $table = "timetable";
    protected $guarded = [
        "id",
        "specialization_id",
        "legend_id",
    ];
    protected $fillable = [
        "day",
        "hour",
        "group",
        "lecturer",
        "lesson",
        "lesson_room",
    ];
    protected $casts = [
        "updated_at" => "datetime:Y-m-d",
    ];

    /**
     * @return BelongsTo<Specialization, Timetable>
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * @return ?BelongsTo<Legend, Timetable>
     */
    public function legend(): ?BelongsTo
    {
        return $this->belongsTo(Legend::class);
    }

    public static function getInstanceByDayHourAndGroup(self $timetable): ?self
    {
        /**
         * @phpstan-ignore-next-line
         */
        return self::query()
            ->where([
                "day" => $timetable->day,
                "hour" => $timetable->hour,
                "group" => $timetable->group,
            ])
            ->get()
            ->first();
    }
}
