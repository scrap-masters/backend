<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\FacultyController;
use App\Http\Resources\FacultyFieldsResource;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\FacultySimpleResource;
use App\Models\Exceptions\FacultyNotFoundException;
use App\Models\Faculty;
use App\Services\Api\FacultyService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class FacultyControllerTest extends TestCase
{
    private array $faculties;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faculties = [
            new Faculty([
                "external_id" => 7,
                "name" => "Wydział Nauk o Zdrowiu i Kulturze Fizycznej",
            ]),
        ];
    }

    public function testIndexFacultySuccess(): void
    {
        $facultyModel = Mockery::mock("Eloquent", Faculty::class);
        $facultyModel->shouldReceive("get")
            ->andReturn(new Collection($this->faculties));

        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getAllFaculties");
        $facultyServiceMock->shouldReceive("getAllFaculties")
            ->once()
            ->andReturn(FacultySimpleResource::collection($this->faculties));

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $facultyResponse = $facultyControllerMock->index();

        $this->assertEquals($facultyResponse->toJson(), '[{"id":null,"externalId":7,"name":"Wydzia\u0142 Nauk o Zdrowiu i Kulturze Fizycznej"}]');
        $this->assertTrue($facultyResponse->response()->isOk());
    }

    public function testFieldsIndexFacultySuccess(): void
    {
        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getFieldsByFaculty");
        $facultyServiceMock->shouldReceive("getFieldsByFaculty")
            ->once()
            ->andReturn(new FacultyFieldsResource($this->faculties[0]));

        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive("findByFacultyId")
            ->andReturn($this->faculties[0]);

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $facultyResponse = $facultyControllerMock->fieldsIndex(7);

        $this->assertEquals($facultyResponse->toJson(), '{"id":null,"fields":[]}');
        $this->assertTrue($facultyResponse->response()->isOk());
    }

    public function testShowFacultySuccess(): void
    {
        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getFacultyById");
        $facultyServiceMock->shouldReceive("getFacultyById")
            ->once()
            ->andReturn(new FacultyResource($this->faculties[0]));

        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive("findByFacultyId")
            ->andReturn($this->faculties[0]);

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $facultyResponse = $facultyControllerMock->show(7);

        $this->assertEquals($facultyResponse->toJson(), '{"id":null,"externalId":7,"name":"Wydzia\u0142 Nauk o Zdrowiu i Kulturze Fizycznej","fields":[]}');
        $this->assertTrue($facultyResponse->response()->isOk());
    }

    public function testIndexFacultyThrowsExceptionNotFound(): void
    {
        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive("get")
            ->andThrow(new ModelNotFoundException());

        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getAllFaculties");
        $facultyServiceMock->shouldReceive("getAllFaculties")
            ->andThrow(new ModelNotFoundException());

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $this->expectException(ModelNotFoundException::class);

        $facultyControllerMock->index();
    }

    public function testFieldsIndexFacultyThrowsExceptionNotFound(): void
    {
        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getFieldsByFaculty");
        $facultyServiceMock->shouldReceive("getFieldsByFaculty")
            ->andThrow(new FacultyNotFoundException());

        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive("findByFacultyId")
            ->andThrow(new FacultyNotFoundException());

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $this->expectException(FacultyNotFoundException::class);

        $facultyControllerMock->fieldsIndex(7);
    }

    public function testShowFacultyThrowsExceptionNotFound(): void
    {
        $facultyServiceMock = Mockery::mock(FacultyService::class)->makePartial()->shouldAllowMockingMethod("getFacultyById");
        $facultyServiceMock->shouldReceive("getFacultyById")
            ->andThrow(new FacultyNotFoundException());

        $facultyModel = Mockery::mock(Faculty::class);
        $facultyModel->shouldReceive("findByFacultyId")
            ->andThrow(new FacultyNotFoundException());

        $facultyControllerMock = new FacultyController($facultyServiceMock);

        $this->expectException(FacultyNotFoundException::class);

        $facultyControllerMock->show(7);
    }
}
