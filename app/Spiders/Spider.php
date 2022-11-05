<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Exceptions\NotFoundEnvException;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use function config;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Spider\AbstractSpider;
use RoachPHP\Spider\Configuration\ArrayLoader;

abstract class Spider extends AbstractSpider
{
    public array $spiderMiddleware = [];
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        [UserAgentMiddleware::class, ['userAgent' => 'Mozilla/5.0 (compatible; RoachPHP/0.1.0)']],
    ];
    public array $itemProcessors = [];
    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];
    public int $concurrency = 5;
    public int $requestDelay = 1;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = config("services.timetable");
        try {
            Validator::make($config, [
                "url" => "required|string",
            ])->validate();
        } catch (ValidationException $e) {
            throw NotFoundEnvException::withMessage(message: "Not found TIMETABLE_URL in env. Please add this env", previous: $e);
        }

        parent::__construct(
            new ArrayLoader([
                "startUrls" => [
                    $config["url"],
                ],
                "downloaderMiddleware" => $this->downloaderMiddleware,
                "spiderMiddleware" => $this->spiderMiddleware,
                "itemProcessors" => $this->itemProcessors,
                "extensions" => $this->extensions,
                "concurrency" => $this->concurrency,
                "requestDelay" => $this->requestDelay,
            ]),
        );
    }
}
