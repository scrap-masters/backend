<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\CamelCaseAttributes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use CamelCaseAttributes;

    public function asJson($value): bool|string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
