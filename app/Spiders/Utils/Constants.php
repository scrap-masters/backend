<?php

declare(strict_types=1);

namespace App\Spiders\Utils;

class Constants
{
    public const FACULTY_URL = "/schedule_view.php?site=show_kierunek.php&id=";
    public const FULL_PLAN_URL = "/checkSpecjalnoscStac.php?specjalnosc=";
    public const SELECTOR_TO_PLAN_LEGEND = "div#prtleg td";
    public const SELECTOR_TO_GROUPS = "td.nazwaSpecjalnosci";
    public const SELECTOR_TO_LESSONS = "td.test";
    public const SELECTOR_TO_LESSON_ROOM = "td.test2";
    public const SELECTOR_TO_DAY = "td.nazwaDnia";
    public const SELECTOR_TO_HOURS = "td.godzina";
    public const SELECTOR_TO_FACULTY_LIST = "//div[@class='page-sidebar']//li/a[contains(text(), 'Wydzia')]";
    public const SELECTOR_TO_FIELD_LIST = "//ul[@class='accordion dark']//li/a";
    public const SELECTOR_TO_SPECIALIZATION_LIST = "//ul[@class='accordion dark']//li/div/a[contains(text(),";
    public const SPECIALIZATIONS_SLUG = "specializationSlug";
    public const FORMAT_DATE = "Y-m-d";
    public const POLISH_LETTERS_TO_REPLACE = ["ą", "ć", "ę", "ł", "ń", "ó", "ś", "ź", "ż", "Ą", "Ć", "Ę", "Ł", "Ń", "Ó", "Ś", "Ź", "Ź"];
    public const POLISH_LETTER_REPLACEMENTS = ["%B1", "%E6", "%EA", "%B3", "%F1", "%F3", "%B6", "%BC", "%BF", "%A1", "%C6", "%CA", "%A3", "%D1", "%D3", "%A6", "%AC", "%AF"];
}
