<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $day
 * @property string $hour
 * @property string $group
 * @property string $lesson
 * @property string $type
 * @property string $title
 * @property string $start
 * @property string $end
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

    protected function title(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => ($attributes["lesson"] === "-") ? "-" : substr(
                $attributes["lesson"],
                0,
                strpos($attributes["lesson"], " "),
            ),
        );
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => ($attributes["lesson"] === "-") ? "-" : substr(
                $attributes["lesson"],
                strpos($attributes["lesson"], "(") + 1,
                -1,
            ),
        );
    }

    protected function start(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => Carbon::createFromFormat(
                "Y-m-d H:i",
                $attributes["day"] . substr($attributes["hour"], 0, -6),
            )->toDateTimeLocalString(),
        );
    }

    protected function end(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => Carbon::createFromFormat(
                "Y-m-d H:i",
                $attributes["day"] . substr($attributes["hour"], strpos($attributes["hour"], "-") + 1),
            )->toDateTimeLocalString(),
        );
    }
}
