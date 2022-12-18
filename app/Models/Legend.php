<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $slug
 * @property string $fullName
 * @property-read Timetable $timetable
 * @property-read Specialization $specialization
 */
class Legend extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = "legend";
    protected $fillable = [
        "slug",
        "full_name",
    ];

    /**
     * @return HasMany<Timetable>
     */
    public function timetable(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    /**
     * @return BelongsTo<Specialization, Legend>
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
