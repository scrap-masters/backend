<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $year
 * @property bool $isFullTime
 * @property-read Faculty $faculty
 * @property-read Collection<Specialization> $specializations
 */
class Field extends Model
{
    use HasFactory;

    protected $table = "fields";
    protected $fillable = [
        "name",
        "year",
        "slug",
        "is_full_time",
    ];

    /**
     * @return BelongsTo<Faculty, Field>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * @return HasMany<Specialization>
     */
    public function specializations(): HasMany
    {
        return $this->hasMany(Specialization::class);
    }
}
