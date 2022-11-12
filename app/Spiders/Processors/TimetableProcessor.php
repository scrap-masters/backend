<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Spiders\Items\TimetableItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

class TimetableProcessor extends CustomItemProcessor
{
    private const DUPLICATE_DIVISOR = 2;

    private int $daysCount = 0;
    private int $groupsCount = 0;
    private int $hoursCount = 0;
    private int $lessonsCount = 0;
    private int $lessonRoomsCount = 0;
    private int $lengthHour = 0;
    private int $lengthGroup = 0;

    /**
     * @param  TimetableItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        $this->setupCursors($item);

        $hours = $item->hours->slice(length: $this->lengthHour);
        $groups = $item->groups->slice(length: $this->lengthGroup);

        $lessonIterator = 0;
        $roomIterator = 0;
        $groupIterator = 0;
        foreach ($item->days as $day) {
            foreach ($hours as $hour) {
                foreach ($groups as $group) {
                    dump($day->textContent);
                    dump($group->textContent);
                    dump($item->lessonRooms->getNode($roomIterator)->textContent);
                    dump($item->lessons->getNode($lessonIterator)->textContent);
                    dump($item->lessons->getNode($lessonIterator + 1)->textContent);
                    dump($hour->textContent);

                    $lessonIterator += 2;
                    $roomIterator++;
                    $groupIterator++;
                    if ($groupIterator === $groups->count()) {
                        $groupIterator = 0;
                        break;
                    }
                }
            }
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
        $this->daysCount = $item->days->count();
        $this->groupsCount = $item->groups->count();
        $this->hoursCount = $item->hours->count();
        $this->lessonsCount = $item->lessons->count();
        $this->lessonRoomsCount = $item->lessonRooms->count();

        $this->lengthHour = (int)$this->hoursCount / $this->daysCount;
        $this->lengthGroup = (int)($this->lessonsCount / self::DUPLICATE_DIVISOR) / $this->hoursCount;
    }
}
