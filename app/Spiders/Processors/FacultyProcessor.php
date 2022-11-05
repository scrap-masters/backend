<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Dto\FacultyDto;
use App\Models\Faculty;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class FacultyProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        $faculty = new FacultyDto($item->get("name"), $item->get("external_id"));
        Faculty::query()->firstOrCreate($faculty->toArray())->save();

        return $item;
    }
}
