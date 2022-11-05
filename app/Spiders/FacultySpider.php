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
        $faculties = $response->filter("li")->slice(0, 3)->each(function (Crawler $crawler): array {
            $str = $crawler->filter("a")->attr("href");

            return [
                "name" => $crawler->text(),
                "externalId" => substr($str, strpos($str, "id=") + 3),
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
