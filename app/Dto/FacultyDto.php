<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Contracts\Support\Arrayable;

class FacultyDto implements Arrayable
{
    public function __construct(
        protected string $name,
        protected int $externalId,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function externalId(): int
    {
        return $this->externalId;
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name(),
            "external_id" => $this->externalId(),
        ];
    }
}
