<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObject;

use App\ValueObject\PolishLetters;
use Tests\TestCase;

class PolishLettersTest extends TestCase
{
    public function testTransformPolishCharacterToUnicodeSuccess(): void
    {
        $polishWords = PolishLetters::change("s1POŁ");

        $this->assertEquals((string)$polishWords, "s1PO%A3");
    }

    public function testTransformPolishCharacterToUrlFormatSuccess(): void
    {
        $polishWords = PolishLetters::changeToUrlFormat("s1POŁ");

        $this->assertEquals((string)$polishWords, "s1PO%C5%81");
    }
}
