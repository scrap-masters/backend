<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Models\Specialization;
use App\Spiders\Items\LegendItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

final class LegendProcessor extends CustomItemProcessor
{
    /**
     * @param  LegendItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        /** @var Specialization $specialization */
        $specialization = Specialization::query()->where("slug", $item->specializationSlug)->first();

        $specialization->legend()->firstOrCreate([
            "slug" => $item->slug,
            "full_name" => $item->fullName,
        ])->save();

        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            LegendItem::class,
        ];
    }
}
