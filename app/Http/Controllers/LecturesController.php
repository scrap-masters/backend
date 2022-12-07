<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\LecturersDto;
use App\Http\Resources\LecturerTimetableResource;
use App\Services\Api\LecturesService;
use Illuminate\Http\Response;

class LecturesController extends Controller
{
    public function __construct(
        public LecturesService $service,
    ) {}

    public function index(): Response
    {
        return new Response(new LecturersDto($this->service->getAllLecturers()));
    }

    public function getPlanForLecturerByName(string $name): LecturerTimetableResource
    {
        return $this->service->getPlanByLecturerByName($name);
    }
}
