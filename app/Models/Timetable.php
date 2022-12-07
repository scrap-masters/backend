<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Utils\Constants;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

    public static function getAllLecturers(): Collection
    {
        return self::query()
            ->pluck("lecturer")
            ->unique();
    }

    public static function getPlanByLecturerName(string $name): Collection
    {
        return self::query()
            ->where("lecturer", "LIKE", "%" . $name . "%")
            ->get();
    }

    protected function title(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => ($attributes["lesson"] === Constants::DIVIDER) ? Constants::DIVIDER : substr(
                $attributes["lesson"],
                Constants::OFFSET_BY_ZERO,
                strpos($attributes["lesson"], Constants::SPACE_CHAR),
            ),
        );
    }

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => ($attributes["lesson"] === Constants::DIVIDER) ? Constants::DIVIDER : substr(
                $attributes["lesson"],
                strpos($attributes["lesson"], Constants::OPENING_BRACKET) + Constants::OFFSET_BY_ONE,
                -1,
            ),
        );
    }

    protected function start(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => Carbon::createFromFormat(
                Constants::DATETIME_FORMAT,
                $attributes["day"] . substr($attributes["hour"], Constants::OFFSET_BY_ZERO, -6),
            )->toDateTimeLocalString(),
        );
    }

    protected function end(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes): string => Carbon::createFromFormat(
                Constants::DATETIME_FORMAT,
                $attributes["day"] . substr($attributes["hour"], strpos($attributes["hour"], Constants::DIVIDER) + Constants::OFFSET_BY_ONE),
            )->toDateTimeLocalString(),
        );
    }
}
