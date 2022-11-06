<?php

declare(strict_types=1);

namespace App\Spiders\Processors\Timetable;

use App\Spiders\Items\TimetableItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;
use RoachPHP\Support\Configurable;

class DayProcessor extends CustomItemProcessor
{
    use Configurable;

    /**
     * @param  TimetableItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        dump($item->days->text());
        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            TimetableItem::class,
        ];
    }
}
