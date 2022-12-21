<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\SpecializationController;
use App\Http\Resources\SpecializationLegendResource;
use App\Http\Resources\SpecializationResource;
use App\Http\Resources\SpecializationTimetableResource;
use App\Models\Exceptions\FieldNotFoundException;
use App\Models\Exceptions\SpecializationNotFoundException;
use App\Models\Specialization;
use App\Services\Api\SpecializationService;
use Illuminate\Database\Eloquent\Collection as EloqCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class SpecializationControllerTest extends TestCase
{
    private array $specializations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->specializations = [
            new Specialization([
                "name" => "s1D (Dietetyka)",
                "slug" => "s1D",
            ]),
        ];
    }

    public function testIndexSpecializationSuccess(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("get")
            ->andReturn(new EloqCollection($this->specializations));

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getAllSpecializations");
        $fieldServiceMock->shouldReceive("getAllSpecializations")
            ->once()
            ->andReturn(SpecializationResource::collection($this->specializations));

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->index();

        $this->assertEquals($fieldResponse->response()->content(), '{"data":[{"id":null,"name":"s1D (Dietetyka)","slug":"s1D","field":null}]}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testTimetableIndexSpecializationSuccess(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andReturn(new EloqCollection($this->specializations));

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getTimetableBySpecialization");
        $fieldServiceMock->shouldReceive("getTimetableBySpecialization")
            ->with(1)
            ->once()
            ->andReturn(new SpecializationTimetableResource($this->specializations[0]));

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->timetableIndex(1);

        $this->assertEquals($fieldResponse->response()->content(), '{"data":{"id":null,"timetable":[]}}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testLegendIndexSpecializationSuccess(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andReturn(new EloqCollection($this->specializations));

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getLegendBySpecialization");
        $fieldServiceMock->shouldReceive("getLegendBySpecialization")
            ->with(1)
            ->once()
            ->andReturn(new SpecializationLegendResource($this->specializations[0]));

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->legendIndex(1);

        $this->assertEquals($fieldResponse->response()->content(), '{"data":{"id":null,"legend":[]}}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testShowSpecializationSuccess(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andReturn(new EloqCollection($this->specializations));

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getSpecializationById");
        $fieldServiceMock->shouldReceive("getSpecializationById")
            ->with(1)
            ->once()
            ->andReturn(new SpecializationResource($this->specializations[0]));

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->show(1);

        $this->assertEquals($fieldResponse->response()->content(), '{"data":{"id":null,"name":"s1D (Dietetyka)","slug":"s1D","field":null}}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testIndexSpecializationThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("get")
            ->andThrow(new FieldNotFoundException());

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getAllSpecializations");
        $fieldServiceMock->shouldReceive("getAllSpecializations")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $this->expectException(ModelNotFoundException::class);

        $fieldControllerMock->index();
    }

    public function testTimetableIndexSpecializationThrowsExceptionSpecializationNotFound(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andThrow(new SpecializationNotFoundException());

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getTimetableBySpecialization");
        $fieldServiceMock->shouldReceive("getTimetableBySpecialization")
            ->with(1)
            ->once()
            ->andThrow(new SpecializationNotFoundException());

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $this->expectException(SpecializationNotFoundException::class);

        $fieldControllerMock->timetableIndex(1);
    }

    public function testLegendIndexSpecializationThrowsExceptionSpecializationNotFound(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andThrow(new SpecializationNotFoundException());

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getLegendBySpecialization");
        $fieldServiceMock->shouldReceive("getLegendBySpecialization")
            ->with(1)
            ->once()
            ->andThrow(new SpecializationNotFoundException());

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $this->expectException(SpecializationNotFoundException::class);

        $fieldControllerMock->legendIndex(1);
    }

    public function testShowSpecializationThrowsExceptionSpecializationNotFound(): void
    {
        $fieldModel = Mockery::mock(Specialization::class);
        $fieldModel->shouldReceive("findBySpecializationId")
            ->andThrow(new SpecializationNotFoundException());

        $fieldServiceMock = Mockery::mock(SpecializationService::class)->makePartial()->shouldAllowMockingMethod("getSpecializationById");
        $fieldServiceMock->shouldReceive("getSpecializationById")
            ->with(1)
            ->once()
            ->andThrow(new SpecializationNotFoundException());

        $fieldControllerMock = new SpecializationController($fieldServiceMock);

        $this->expectException(SpecializationNotFoundException::class);

        $fieldControllerMock->show(1);
    }
}
