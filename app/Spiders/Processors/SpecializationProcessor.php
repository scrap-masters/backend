<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Models\Field;
use App\Spiders\Items\SpecializationItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

final class SpecializationProcessor extends CustomItemProcessor
{
    /**
     * @param SpecializationItem $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        $field = Field::query()->where("slug", $item->fieldSlug)->first();

        $field->specializations()->firstOrCreate([
            "name" => $item->name,
            "slug" => $item->slug,
        ]);

        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            SpecializationItem::class,
        ];
    }
}
