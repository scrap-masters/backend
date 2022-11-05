<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Dto\FacultyDto;
use App\Spiders\Processors\FacultyProcessor;
use Generator;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class FacultySpider extends Spider
{
    public array $itemProcessors = [
        FacultyProcessor::class,
    ];

    public function parse(Response $response): Generator
    {
        $faculties = $response->filterXPath('//div[@class="page-sidebar"]//li/a[contains(text(), "Wydzia")]')->each(function (Crawler $crawler): array {
            $href = $crawler->filter("a")->attr("href");

            return [
                "name" => $crawler->text(),
                "externalId" => substr($href, strpos($href, "id=") + 3),
            ];
        });

        foreach ($faculties as $faculty) {
            $facultyDto = new FacultyDto(
                $faculty["name"],
                intval($faculty["externalId"]),
            );
            yield $this->item($facultyDto->toArray());
        }
    }
}
