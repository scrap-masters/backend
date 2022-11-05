<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Dto\LegendDto;
use App\Models\Legend;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class LegendProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        $legend = new LegendDto($item->get("slug"), $item->get("full_name"));
        Legend::query()->firstOrCreate($legend->toArray())->save();

        return $item;
    }
}
