<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Models\Specialization;
use App\Models\Timetable;
use App\Spiders\Items\TimetableItem;
use Illuminate\Database\Eloquent\Collection;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

class TimetableProcessor extends CustomItemProcessor
{
    private const DUPLICATE_DIVISOR = 2;

    private int $lengthHour = 0;
    private int $lengthGroup = 0;

    /**
     * @param  TimetableItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        $this->setupCursors($item);

        $specialty = $this->getSpecialtyFromRequestUri($item);
        $specialization = Specialization::query()->where("slug", $specialty)->get("id")->first();
        $hours = $item->hours->slice(length: $this->lengthHour);
        $groups = $item->groups->slice(length: $this->lengthGroup);

        $lessonIterator = 0;
        $roomIterator = 0;
        $groupIterator = 0;

        foreach ($item->days as $day) {
            $timetables = new Collection();
            foreach ($hours as $hour) {
                foreach ($groups as $group) {
                    $timetable = new Timetable([
                        "day" => $day->textContent,
                        "hour" => $hour->textContent,
                        "group" => $group->textContent,
                        "lecturer" => $item->lessons->getNode($lessonIterator + 1)->textContent,
                        "lesson" => $item->lessons->getNode($lessonIterator)->textContent,
                        "lesson_room" => $item->lessonRooms->getNode($roomIterator)->textContent,
                    ]);
                    $timetable->specialization()->associate($specialization);

                    $timetables->add($timetable);
                    $lessonIterator += 2;
                    $roomIterator++;
                    $groupIterator++;
                    if ($groupIterator === $groups->count()) {
                        $groupIterator = 0;
                        break;
                    }
                }
            }
            $this->saveOrUpdateTimetable($timetables);
        }

        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            TimetableItem::class,
        ];
    }

    private function setupCursors(ItemInterface $item): void
    {
        $daysCount = $item->days->count();
        $hoursCount = $item->hours->count();
        $lessonsCount = $item->lessons->count();

        $this->lengthHour = (int)$hoursCount / $daysCount;
        $this->lengthGroup = (int)($lessonsCount / self::DUPLICATE_DIVISOR) / $hoursCount;
    }

    private function getSpecialtyFromRequestUri(ItemInterface $item): string
    {
        $urlRequest = parse_url($item->days->getUri());

        parse_str($urlRequest["query"], $params);

        return urlencode($params["specjalnosc"]);
    }

    private function saveOrUpdateTimetable(Collection $timetables): void
    {
        $timetables->each(function ($timetable): void {
            Timetable::query()->where('day')->andWhere('hour')->andWhere('group');
            $timetable->save();
        });
    }
}
