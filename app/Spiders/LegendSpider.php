<?php

declare(strict_types=1);

namespace App\Spiders;

use Generator;
use RoachPHP\Http\Response;

class LegendSpider extends Spider
{
    private const SELECTOR_TO_PLAN_LEGEND = "div#prtleg td";

    public function parse(Response $response): Generator
    {
        $legends = $response->filter(self::SELECTOR_TO_PLAN_LEGEND);
        $count = $legends->count();
        for ($i = 0; $i < $count; $i++) {
            // Todo: Add maping data for Dto and build collections items for this
            // Todo: Add procesor to process data from dto to model and save
            yield $this->item([
                "slug" => $legends->getNode($i)->textContent,
                "full_name" => $legends->getNode($i)->textContent,
            ]);
        }
    }
}
