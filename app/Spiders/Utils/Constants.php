<?php

declare(strict_types=1);

namespace App\Spiders\Utils;

class Constants
{
    public const FACULTY_URL = "http://www.plan.collegiumwitelona.pl/schedule_view.php?site=show_kierunek.php&id=";
    public const SELECTOR_TO_PLAN_LEGEND = "div#prtleg td";
    public const SELECTOR_TO_FACULTY_LIST = "//div[@class='page-sidebar']//li/a[contains(text(), 'Wydzia')]";
    public const SELECTOR_TO_FIELD_LIST = "//ul[@class='accordion dark']//li/a";
}
