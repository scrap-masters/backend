<?php

declare(strict_types=1);

namespace App\Spiders\Utils;

class Constants
{
    public const FACULTY_URL = "/schedule_view.php?site=show_kierunek.php&id=";
    public const SELECTOR_TO_PLAN_LEGEND = "div#prtleg td";
    public const SELECTOR_TO_GROUPS = "td.nazwaSpecjalnosci";
    public const SELECTOR_TO_LESSONS = "td.test";
    public const SELECTOR_TO_LESSON_ROOM = "td.test2";
    public const SELECTOR_TO_DAY = "td.nazwaDnia";
    public const SELECTOR_TO_HOURS = "td.godzina";
    public const SELECTOR_TO_FACULTY_LIST = "//div[@class='page-sidebar']//li/a[contains(text(), 'Wydzia')]";
    public const SELECTOR_TO_FIELD_LIST = "//ul[@class='accordion dark']//li/a";
    public const SELECTOR_TO_SPECIALIZATION_LIST = "//ul[@class='accordion dark']//li/div/a[contains(text(), '(')]";
}
