<?php

declare(strict_types=1);

namespace App\Spiders\Processors;

use App\Spiders\Items\TimetableItem;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\CustomItemProcessor;

class TimetableProcessor extends CustomItemProcessor
{
    /**
     * @param  TimetableItem  $item
     */
    public function processItem(ItemInterface $item): ItemInterface
    {
        $daysCount = $item->days->count();
        $groupsCount = $item->groups->count();
        $hoursCount = $item->hours->count();
        $lessonsCount = $item->lessons->count() / 2;

        //1 dzien to 7 wykladów/cwiczen
        // liczba lekcji dzielimy na 2 bo skrót lekcji tez jest zaliczany
        // ilosc group = lessouns count / hours count
        dump($daysCount);
        dump($groupsCount);
        dump($hoursCount);
        dump($lessonsCount);

        dump($item->days->getNode(0)->textContent);
        dump($item->groups->getNode(1)->textContent);
        dump($item->hours->getNode(1)->textContent);
        dump($item->lessonRooms->getNode(6)->textContent);
        dump($item->lessons->getNode(12)->textContent);
        dump($item->lessons->getNode(12+1)->textContent);

        $lessonsIterator = 0;
        $rowIterator = 0 ;
        foreach ($item->days as $day)
        {
            foreach ($item->hours as $hour) {
                foreach ($item->groups as $group) {
                    while ($rowIterator <= 6) {


                        $lessonsIterator++;

                    }
                }
            }
            dump($day->textContent);
        }



/*        for ($a = 0; $a < $daysCount; $a++) {
                 for ($b = 0; $b < $groupsCount; $b++) {
                     for ($c = 0; $c < $hoursCount; $c++) {
                         for ($d = 0; $d < $lessonsCount; $d++) {
                         }
                     }
                     exit();
                 }
             }*/
        return $item;
    }

    protected function getHandledItemClasses(): array
    {
        return [
            TimetableItem::class,
        ];
    }
}
