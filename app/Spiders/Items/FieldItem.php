<?php

declare(strict_types=1);

namespace App\Spiders\Items;

use RoachPHP\ItemPipeline\AbstractItem;

final class FieldItem extends AbstractItem
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly bool $isFullTime,
        public readonly int $facultyExternalId,
    ) {}
}
