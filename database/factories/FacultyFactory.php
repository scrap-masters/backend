<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            "external_id" => 7,
            "name" => "Wydział Nauk o Zdrowiu i Kulturze Fizycznej",
        ];
    }
}
