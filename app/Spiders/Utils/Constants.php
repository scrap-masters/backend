<?php

declare(strict_types=1);

namespace App\Spiders\Utils;

class Constants
{
    public const SELECTOR_TO_PLAN_LEGEND = "div#prtleg td";
    public const SELECTOR_TO_FACULTY_LIST = "//div[@class='page-sidebar']//li/a[contains(text(), 'Wydzia')]";
}
