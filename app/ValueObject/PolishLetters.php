<?php

declare(strict_types=1);

namespace App\ValueObject;

use Stringable;

class PolishLetters implements Stringable
{
    private const POLISH_LETTERS_TO_REPLACE = [
        "ą", "ć", "ę", "ł", "ń", "ó", "ś", "ź", "ż", "Ą", "Ć", "Ę", "Ł", "Ń", "Ó", "Ś", "Ź", "Ź",
    ];
    private const POLISH_LETTER_REPLACEMENTS = [
        "%B1", "%E6", "%EA", "%B3", "%F1", "%F3", "%B6", "%BC", "%BF", "%A1", "%C6", "%CA", "%A3", "%D1", "%D3", "%A6",
        "%AC", "%AF",
    ];

    private string $words;

    private function __construct(string $words)
    {
        $fixedWords = str_replace(
            self::POLISH_LETTERS_TO_REPLACE,
            self::POLISH_LETTER_REPLACEMENTS,
            $words,
        );

        $this->words = $fixedWords;
    }

    public function __toString(): string
    {
        return $this->words;
    }

    public static function change(string $words): self
    {
        return new self($words);
    }

    public static function changeToUrlFormat(string $words): self
    {
        return new self(urlencode($words));
    }
}
