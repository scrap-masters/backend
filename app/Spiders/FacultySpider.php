<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Spiders\Items\FacultyItem;
use App\Spiders\Items\FieldItem;
use App\Spiders\Processors\FacultyProcessor;
use App\Spiders\Processors\FieldProcessor;
use App\Spiders\Utils\Constants;
use Generator;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class FacultySpider extends Spider
{
    public array $itemProcessors = [
        FacultyProcessor::class,
        FieldProcessor::class,
    ];

    public function parse(Response $response): Generator
    {
        $faculties = $response->filterXPath(Constants::SELECTOR_TO_FACULTY_LIST)->each(function (Crawler $crawler): array {
            $href = $crawler->filter("a")->attr("href");

            return [
                "name" => $crawler->text(),
                "externalId" => substr($href, strpos($href, "id=") + 3),
            ];
        });

        foreach ($faculties as $faculty) {
            $facultyItem = new FacultyItem(
                $faculty["name"],
                intval($faculty["externalId"]),
            );
            yield $this->item($facultyItem);

            yield $this->request(
                "GET",
                Constants::FACULTY_URL . $faculty["externalId"],
                "parseFacultyPage",
            );
        }
    }

    public function parseFacultyPage(Response $response): Generator
    {
        $fields = $response->filterXPath(Constants::SELECTOR_TO_FIELD_LIST)->each(function (Crawler $crawler): array {
            return [
                "name" => substr($crawler->text(), 0, strpos($crawler->text(), "-")),
                "slug" => substr($crawler->text(), strpos($crawler->text(), "(") + 1, -1),
                "fullTime" => substr($crawler->text(), strpos($crawler->text(), "(") + 1, 1) === "s",
                "facultyExternalId" => substr($crawler->getUri(), strpos($crawler->getUri(), "id=") + 3),
            ];
        });

        foreach ($fields as $field) {
            $fieldItem = new FieldItem(
                $field["name"],
                $field["slug"],
                $field["fullTime"],
                intval($field["facultyExternalId"]),
            );
            yield $this->item($fieldItem);
        }
    }
}
