<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldSpecializationsResource;
use App\Models\Field;
use App\Services\Api\FieldService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FieldController extends Controller
{
    public function __construct(
        public FieldService $service,
    ) {}

    public function index(): ResourceCollection
    {
        return $this->service->getAllFields();
    }

    public function specializationsIndex(Field $field): FieldSpecializationsResource
    {
        return $this->service->getSpecializationsByField($field);
    }

    public function show(Field $field): FieldResource
    {
        return $this->service->getFieldById($field);
    }
}
