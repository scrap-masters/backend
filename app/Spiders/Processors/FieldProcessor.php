<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Models\Faculty;
use App\Spiders\Items\FieldItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

final class FieldProcessor extends CustomItemProcessor
{
    /**
     * @param FieldItem $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        $faculty = Faculty::query()->where("external_id", $item->facultyExternalId)->first();

        /** @var Faculty $faculty */
        $faculty->fields()->firstOrCreate([
            "name" => $item->name,
            "year" => $item->year,
            "slug" => $item->slug,
            "is_full_time" => $item->isFullTime,
        ]);

        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            FieldItem::class,
        ];
    }
}
