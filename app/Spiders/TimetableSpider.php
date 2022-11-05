<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Spiders\Processors\TimetableProcessor;
use App\Spiders\Utils\Constants;
use Generator;
use RoachPHP\Http\Response;

class TimetableSpider extends Spider
{
    public array $itemProcessors = [
        TimetableProcessor::class,
    ];

    // Todo: Must be add to link checkSpecjalnosc + Stac becouse then get plan for all term
    public function parse(Response $response): Generator
    {
        $lessons = $response->filter(Constants::SELECTOR_TO_LESSON_ROOM);
        $count = $lessons->count();
        for ($i = 0; $i < $count; $i++) {
            dump($lessons->getNode($i)->textContent);
            yield $this->item([]);
        }
    }
}
