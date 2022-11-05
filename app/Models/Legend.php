<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $shorName
 * @property string $fullName
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
}
