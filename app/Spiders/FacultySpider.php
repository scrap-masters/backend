<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Spiders\Items\FacultyItem;
use App\Spiders\Items\FieldItem;
use App\Spiders\Items\SpecializationItem;
use App\Spiders\Processors\FacultyProcessor;
use App\Spiders\Processors\FieldProcessor;
use App\Spiders\Processors\SpecializationProcessor;
use App\Spiders\Utils\Constants;
use Generator;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class FacultySpider extends Spider
{
    public array $itemProcessors = [
        FacultyProcessor::class,
        FieldProcessor::class,
        SpecializationProcessor::class,
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
                $response->getUri() . Constants::FACULTY_URL . $faculty["externalId"],
                "parseFields",
                ["facultyExternalId" => intval($faculty["externalId"])],
            );
        }
    }

    public function parseFields(Response $response): Generator
    {
        $options = $response->getRequest()->getOptions();

        $fields = $response->filterXPath(Constants::SELECTOR_TO_FIELD_LIST)->each(function (Crawler $crawler): array {
            $text = $crawler->text();

            return [
                "name" => substr($text, 0, strpos($text, "-")),
                "slug" => substr($text, strpos($text, "(") + 1, -1),
                "isFullTime" => substr($text, strpos($text, "(") + 1, 1) === "s",
            ];
        });

        foreach ($fields as $field) {
            $fieldItem = new FieldItem(
                $field["name"],
                $field["slug"],
                $field["isFullTime"],
                $options["facultyExternalId"],
            );
            yield $this->item($fieldItem);

            yield $this->request(
                "GET",
                $response->getUri() . Constants::FACULTY_URL . $options["facultyExternalId"],
                "parseSpecializations",
                ["fieldSlug" => $field["slug"]],
            );
        }
    }

    public function parseSpecializations(Response $response): Generator
    {
        $options = $response->getRequest()->getOptions();

        $specializations = $response->filterXPath(Constants::SELECTOR_TO_SPECIALIZATION_LIST)->each(function (Crawler $crawler): array {
            $specializationsText = $crawler->text();

            return [
                "name" => substr($specializationsText, 0, strpos($specializationsText, " ")),
            ];
        });

        foreach ($specializations as $specialization) {
            $specializationItem = new SpecializationItem(
                $specialization["name"],
                $specialization["name"],
                $options["fieldSlug"],
            );
            yield $this->item($specializationItem);
        }
    }
}
