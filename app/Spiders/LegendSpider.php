<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Spiders\Items\LegendItem;
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
        yield $this->request(
            "GET",
            $response->getUri() . Constants::FULL_PLAN_URL . str_replace(
                Constants::POLISH_LETTERS_TO_REPLACE,
                Constants::POLISH_LETTER_REPLACEMENTS,
                $this->context[Constants::SPECIALIZATIONS_SLUG],
            ),
            "parseLegends",
        );
    }

    public function parseLegends(Response $response): Generator
    {
        $legends = $response->filter(Constants::SELECTOR_TO_PLAN_LEGEND);
        $count = $legends->count();
        for ($i = 0; $i < $count; $i = $i + 2) {
            $legend = new LegendItem(
                $legends->getNode($i)->textContent,
                $legends->getNode($i + 1)->textContent,
                $this->context[Constants::SPECIALIZATIONS_SLUG],
            );

            yield $this->item($legend);
        }
    }
}
