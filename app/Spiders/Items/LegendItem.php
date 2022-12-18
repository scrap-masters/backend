<?php

declare(strict_types=1);

namespace App\Spiders\Items;

use RoachPHP\ItemPipeline\AbstractItem;

final class LegendItem extends AbstractItem
{
    public function __construct(
        public readonly string $slug,
        public readonly string $fullName,
        public readonly string $specializationSlug,
    ) {}
}
