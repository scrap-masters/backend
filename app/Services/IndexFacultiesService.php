<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Collection;

class IndexFacultiesService
{
    public function index(): Collection
    {
        return Faculty::all();
    }
}
