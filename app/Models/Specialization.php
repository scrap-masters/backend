<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read Field $field
 * @property-read Timetable $timetable
 */
class Specialization extends Model
{
    use HasFactory;

    protected $table = "specializations";
    protected $fillable = [
        "name",
        "slug",
    ];

    /**
     * @return BelongsTo<Field, Specialization>
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * @return HasMany<Timetable>
     */
    public function timetable(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }
}
