<?php

declare(strict_types=1);

namespace App\Spiders\Items;

use RoachPHP\ItemPipeline\AbstractItem;

final class SpecializationItem extends AbstractItem
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $fieldSlug,
    ) {}
}
