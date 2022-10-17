<?php

declare(strict_types=1);

namespace App\Spiders;

use Generator;
use JetBrains\PhpStorm\NoReturn;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use Symfony\Component\DomCrawler\Crawler;

class FacultySpider extends BasicSpider
{
    /** @var array<string> */
    public array $startUrls = [
        "http://www.plan.collegiumwitelona.pl/",
    ];

    #[NoReturn]
    public function parse(Response $response): Generator
    {
        $faculties = $response->filter("li")->slice(0, 3)->each(function (Crawler $crawler): array {
            return [
                $crawler->text(),
            ];
        });

        yield $this->item([
            "faculties" => $faculties,
        ]);
    }
}
