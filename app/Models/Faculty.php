<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $externalId
 * @property string $name
 * @property-read Collection<Field> $fields
 */
class Faculty extends Model
{
    use HasFactory;

    protected $table = "faculties";
    protected $fillable = [
        "external_id",
        "name",
    ];

    /**
     * @return HasMany<Field>
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }
}
