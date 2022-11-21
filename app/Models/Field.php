<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Exceptions\FieldNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $slug
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

    /**
     * @throws FieldNotFoundException
     */
    public static function findByFieldId(int $fieldId): self
    {
        /** @var \Illuminate\Database\Eloquent\Collection|null $fields */
        $fields = self::query()->where("id", $fieldId)
            ->limit(1)
            ->get();

        if ($fields->first() === null) {
            throw new FieldNotFoundException();
        }
        return $fields->first();
    }
}
