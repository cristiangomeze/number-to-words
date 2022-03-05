<?php

namespace NumberToWords\Language\Spanish;

class SpanishConverter
{
    private SpanishDictionary $dictionary;

    public function __construct(SpanishDictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function convert($number)
    {
        return trim($this->transformToWords($number, 0));
    }

    protected function transformToWords(int $number, int $power): string
    {
        $words = [];

        if ($number === 0) {
            return $this->dictionary->getZero();
        }

        if ($number < 0) {
            $words[] = $this->dictionary->getMinus();
            $number *= -1;
        }

        list($number, $words[]) = $this->needToUsedPower($power, $number);

        $units = $number % 10;
        $tens = (int) ($number / 10) % 10;
        $hundreds = (int) ($number / 100) % 10;
        
        $words[] = $this->getThousands($number);
        $words[] = $this->getHundred($hundreds, $tens, $units);
        $words[] = $this->getTens($tens, $units, $power);
        $words[] = $this->getDigitsOnlyForMultipleOfTen($tens, $units, $power);
        $words[] = $this->getExponent($hundreds, $tens, $units, $power, $number);

        return implode('', array_filter($words, fn ($word) => strlen(trim($word))));
    }

    private function needToUsedPower($power, $number)
    {
        if (! $this->numberIsAboveSixUnits($number)) {
            return [$number, null];
        }

        return [substr($number, -6), $this->highestPower($power, $this->numberWithCorrespondingPower($number))];
    }

    private function numberIsAboveSixUnits($number)
    {
        return (strlen($number) > 6);
    }

    private function numberWithCorrespondingPower($number)
    {
        return preg_replace('/^0+/', '', substr($number, 0, -6));
    }

    private function highestPower($power, $snum)
    {
        return $this->checkHighestPower($power, $snum)
            ? $this->transformToWords($snum, $power + 6)
            : null;
    }

    private function checkHighestPower($power, $snum)
    {
        return isset(SpanishDictionary::$exponent[$power]) && $snum !== '';
    }

    private function getThousands($number)
    {
        $thousands = floor($number / 1000);

        if ($thousands == 1) {
            return $this->dictionary->wordSeparator . 'mil';
        }

        if ($thousands > 1) {
            return $this->transformToWords($thousands, 3);
        }
    }

    private function getHundred($hundreds, $tens, $units)
    {   
        if ($hundreds == 1 && $units == 0 && $tens == 0) {
            return $this->dictionary->wordSeparator . 'cien';
        }
        
        return $this->dictionary->wordSeparator . $this->dictionary->getCorrespondingHundred($hundreds);
    }

    private function getTens($tens, $units, $power)
    {
        if ($tens == 1) {
            return $this->dictionary->wordSeparator . $this->dictionary->getCorrespondingTeen($units);
        }

        if ($tens == 2 && $units <> 0) {
            return ($power > 0 && $units == 1) 
                ? $this->dictionary->wordSeparator . 'veintiún' 
                : $this->dictionary->wordSeparator . 'veinti' . $this->dictionary->getCorrespondingUnit($units);
        }

        return $this->dictionary->wordSeparator . $this->dictionary->getCorrespondingTen($tens);
    }

    private function getDigitsOnlyForMultipleOfTen($tens, $units, $power)
    {
        if (! ($tens <> 1 && $tens <> 2 && $units > 0)) {
           return;
        }

        if ($tens <> 0) {
            return $this->dictionary->wordSeparator . 'y ' . $this->dictionary->getCorrespondingUnit($units);
        }

        if ($power > 0 && $units == 1) {
            return $this->dictionary->wordSeparator . 'un';
        }  
        
        return $this->dictionary->wordSeparator . $this->dictionary->getCorrespondingUnit($units);
    }

    private function getExponent($hundreds, $tens, $units, $power, $number)
    {
        if ($this->hasNotExponentKey($power) || !($number <> 0)) {
            return;
        }

        return $this->dictionary->wordSeparator . $this->exponentName($hundreds, $tens, $units, SpanishDictionary::$exponent[$power]);
    }

    private function hasNotExponentKey($power)
    {
        return !($power > 0) 
            && !array_key_exists($power, SpanishDictionary::$exponent[$power]) 
            && !is_array(SpanishDictionary::$exponent[$power]);
    }

    private function exponentName($hundreds, $tens, $units, $exponent)
    {
        return ($units == 1 && $tens == 0 && $hundreds == 0) ? $exponent[0] : $exponent[1];
    }
}