<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Models\Faculty;
use App\Spiders\Items\FacultyItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

final class FacultyProcessor extends CustomItemProcessor
{
    /**
     * @param FacultyItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        Faculty::query()->firstOrCreate([
            "name" => $item->name,
            "external_id" => $item->externalId,
        ])->save();

        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            FacultyItem::class,
        ];
    }
}
