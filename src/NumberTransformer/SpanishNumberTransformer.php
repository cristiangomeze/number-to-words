<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Language\Spanish\SpanishConverter;
use NumberToWords\Language\Spanish\SpanishDictionary;

class SpanishNumberTransformer implements NumberTransformer
{
    public function toWords(int $number): string
    {
        return (new SpanishConverter(new SpanishDictionary()))->convert($number);
    }
}
