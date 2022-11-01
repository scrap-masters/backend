<?php

declare(strict_types=1);

namespace App\Spiders;

use Generator;
use RoachPHP\Http\Response;

class LegendSpider extends Spider
{
    public function parse(Response $response): Generator
    {
        $title = $response->filter("h1")->text();

        dump($title);
        yield $this->item([$title]);
    }
}
