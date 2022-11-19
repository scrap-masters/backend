<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use App\Services\Api\SpecializationService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecializationController extends Controller
{
    public function __construct(
        public SpecializationService $service,
    ) {}

    public function index(): ResourceCollection
    {
        return $this->service->getAllSpecializations();
    }

    public function show(Specialization $specialization): SpecializationResource
    {
        return $this->service->getSpecializationById($specialization);
    }
}
