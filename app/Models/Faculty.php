<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Exceptions\FacultyNotFoundException;
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

    /**
     * @throws FacultyNotFoundException
     */
    public static function findByFacultyId(int $facultyId): self
    {
        /** @var \Illuminate\Database\Eloquent\Collection|null $faculty */
        $faculty = self::query()->where("id", $facultyId)
            ->limit(1)
            ->get();

        if ($faculty === null) {
            throw new FacultyNotFoundException();
        }
        return $faculty->first();
    }
}
