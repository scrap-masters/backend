<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Contracts\Support\Arrayable;

class LegendDto implements Arrayable
{
    public function __construct(
        protected string $slug,
        protected string $fullName,
    ) {}

    public function slug(): string
    {
        return $this->slug;
    }

    public function fullName(): string
    {
        return $this->fullName;
    }

    public function toArray(): array
    {
        return [
            "slug" => $this->slug(),
            "full_name" => $this->fullName(),
        ];
    }
}
