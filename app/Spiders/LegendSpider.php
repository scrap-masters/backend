<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Dto\LegendDto;
use App\Spiders\Processors\LegendProcessor;
use App\Spiders\Utils\Constants;
use Generator;
use RoachPHP\Http\Response;

class LegendSpider extends Spider
{
    public array $itemProcessors = [
        LegendProcessor::class,
    ];

    public function parse(Response $response): Generator
    {
        $legends = $response->filter(Constants::SELECTOR_TO_PLAN_LEGEND);
        $count = $legends->count();
        for ($i = 1; $i < $count; $i = $i + 2) {
            $legend = new LegendDto(
                $legends->getNode($i)->textContent,
                $legends->getNode($i + 1)->textContent,
            );
            yield $this->item($legend->toArray());
        }
    }
}
