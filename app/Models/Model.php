<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\CamelCaseAttributes;
use App\Models\Utils\Constants;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Rennokki\QueryCache\Traits\QueryCacheable;

abstract class Model extends EloquentModel
{
    use CamelCaseAttributes;
    use QueryCacheable;

    protected int $cacheFor = Constants::HALF_AN_HOUR;
    protected string $cacheDriver = "redis";
    protected static bool $flushCacheOnUpdate = true;

    public function asJson($value): bool|string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
