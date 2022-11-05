<?php

declare(strict_types=1);

namespace App\Spiders\Processors\Timetable;

use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;
use Symfony\Component\DomCrawler\Crawler;

class DayProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        /**
         * @param Crawler $itemAA
         */
        $itemAA = $item->get("days");
        dd($itemAA->getNode(0)->textContent);
        return $item;
    }
}
