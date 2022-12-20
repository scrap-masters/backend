<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\FieldController;
use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldSpecializationsResource;
use App\Models\Exceptions\FieldNotFoundException;
use App\Models\Field;
use App\Services\Api\FieldService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class FieldControllerTest extends TestCase
{
    private array $fields;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fields = [
            new Field([
                "name" => "Dietetyka",
                "year" => 2,
                "slug" => "s1D",
                "is_full_time" => true,
            ]),
        ];
    }

    public function testIndexFieldSuccess(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("get")
            ->andReturn(new Collection($this->fields));

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getAllFields");
        $fieldServiceMock->shouldReceive("getAllFields")
            ->once()
            ->andReturn(FieldResource::collection($this->fields));

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->index();

        $this->assertEquals($fieldResponse->toJson(), '[{"id":null,"name":"Dietetyka","year":2,"slug":"s1D","isFullTime":true,"faculty":null,"specializations":[]}]');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testSpecializationIndexSuccess(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("findByFieldId")
            ->andReturn($this->fields[0]);

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getSpecializationsByFieldId");
        $fieldServiceMock->shouldReceive("getSpecializationsByFieldId")
            ->once()
            ->andReturn(new FieldSpecializationsResource($this->fields[0]));

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->specializationsIndex(1);

        $this->assertEquals($fieldResponse->toJson(), '{"id":null,"specializations":[]}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testShowFieldSuccess(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("findByFieldId")
            ->andReturn($this->fields[0]);

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getFieldById");
        $fieldServiceMock->shouldReceive("getFieldById")
            ->once()
            ->andReturn(new FieldResource($this->fields[0]));

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->show(1);

        $this->assertEquals($fieldResponse->toJson(), '{"id":null,"name":"Dietetyka","year":2,"slug":"s1D","isFullTime":true,"faculty":null,"specializations":[]}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testIndexFieldThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("get")
            ->andThrow(new ModelNotFoundException());

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getAllFields");
        $fieldServiceMock->shouldReceive("getAllFields")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $this->expectException(ModelNotFoundException::class);

        $fieldControllerMock->index();
    }

    public function testFieldsIndexFacultyThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("findByFieldId")
            ->andThrow(new FieldNotFoundException());

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getSpecializationsByFieldId");
        $fieldServiceMock->shouldReceive("getSpecializationsByFieldId")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $this->expectException(FieldNotFoundException::class);

        $fieldControllerMock->specializationsIndex(1);
    }

    public function testShowFacultyThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Field::class);
        $fieldModel->shouldReceive("findByFieldId")
            ->andThrow(new FieldNotFoundException());

        $fieldServiceMock = Mockery::mock(FieldService::class)->makePartial()->shouldAllowMockingMethod("getFieldById");
        $fieldServiceMock->shouldReceive("getFieldById")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new FieldController($fieldServiceMock);

        $this->expectException(FieldNotFoundException::class);

        $fieldControllerMock->show(1);
    }
}
