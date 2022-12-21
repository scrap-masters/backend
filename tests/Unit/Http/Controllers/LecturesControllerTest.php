<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\LecturesController;
use App\Http\Resources\LecturerTimetableResource;
use App\Models\Exceptions\FieldNotFoundException;
use App\Models\Timetable;
use App\Services\Api\LecturesService;
use Illuminate\Database\Eloquent\Collection as EloqCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class LecturesControllerTest extends TestCase
{
    private array $lectures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->lectures = [
            new Timetable([
                "day" => "2022-10-04",
                "hour" => "08:15-09:45",
                "group" => "s1D1u",
                "lecturer" => "dr Małgorzata Jusiakowska - Piputa",
                "lesson" => "Moiż (lab)",
                "lesson_room" => "D18",
            ]),
        ];
    }

    public function testIndexFieldSuccess(): void
    {
        $fieldModel = Mockery::mock(Timetable::class);
        $fieldModel->shouldReceive("getAllLecturers")
            ->andReturn(new EloqCollection($this->lectures));

        $fieldServiceMock = Mockery::mock(LecturesService::class)->makePartial()->shouldAllowMockingMethod("getAllLecturers");
        $fieldServiceMock->shouldReceive("getAllLecturers")
            ->once()
            ->andReturn(new Collection($this->lectures));

        $fieldControllerMock = new LecturesController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->index();

        $this->assertEquals($fieldResponse->content(), '{"data":[{"day":"2022-10-04","hour":"08:15-09:45","group":"s1D1u","lecturer":"dr Ma\u0142gorzata Jusiakowska - Piputa","lesson":"Moi\u017c (lab)","lesson_room":"D18"}]}');
        $this->assertTrue($fieldResponse->isOk());
    }

    public function testGetPlanByNameLecturesSuccess(): void
    {
        $fieldModel = Mockery::mock(Timetable::class);
        $fieldModel->shouldReceive("getPlanByLecturerName")
            ->andReturn(new EloqCollection($this->lectures));

        $fieldServiceMock = Mockery::mock(LecturesService::class)->makePartial()->shouldAllowMockingMethod("getPlanByLecturerByName");
        $fieldServiceMock->shouldReceive("getPlanByLecturerByName")
            ->with("Jusiakowska")
            ->once()
            ->andReturn(new LecturerTimetableResource($this->lectures));

        $fieldControllerMock = new LecturesController($fieldServiceMock);

        $fieldResponse = $fieldControllerMock->getPlanForLecturerByName("Jusiakowska");

        $this->assertEquals($fieldResponse->response()->content(), '{"data":{"timetable":[{"id":null,"legend_id":null,"start":"2022-10-04T08:15:00","end":"2022-10-04T09:45:00","group":"s1D1u","lecturer":"dr Ma\u0142gorzata Jusiakowska - Piputa","title":"Moi\u017c","type":"lab","room":"D18"}]}}');
        $this->assertTrue($fieldResponse->response()->isOk());
    }

    public function testIndexThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Timetable::class);
        $fieldModel->shouldReceive("getAllLecturers")
            ->andThrow(new FieldNotFoundException());

        $fieldServiceMock = Mockery::mock(LecturesService::class)->makePartial()->shouldAllowMockingMethod("getAllLecturers");
        $fieldServiceMock->shouldReceive("getAllLecturers")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new LecturesController($fieldServiceMock);

        $this->expectException(ModelNotFoundException::class);

        $fieldControllerMock->index();
    }

    public function testGetPlanByNameLecturesThrowsExceptionNotFound(): void
    {
        $fieldModel = Mockery::mock(Timetable::class);
        $fieldModel->shouldReceive("getPlanByLecturerName")
            ->andThrow(new FieldNotFoundException());

        $fieldServiceMock = Mockery::mock(LecturesService::class)->makePartial()->shouldAllowMockingMethod("getPlanByLecturerByName");
        $fieldServiceMock->shouldReceive("getPlanByLecturerByName")
            ->with("Jusiakowska")
            ->once()
            ->andThrow(new FieldNotFoundException());

        $fieldControllerMock = new LecturesController($fieldServiceMock);

        $this->expectException(ModelNotFoundException::class);

        $fieldControllerMock->getPlanForLecturerByName("Jusiakowska");
    }
}
