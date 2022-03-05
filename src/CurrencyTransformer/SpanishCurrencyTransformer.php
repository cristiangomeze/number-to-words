<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\Spanish\SpanishConverter;
use NumberToWords\Language\Spanish\SpanishDictionary;
use NumberToWords\TransformerOptions\CurrencyTransformerOptions;

class SpanishCurrencyTransformer implements CurrencyTransformer
{
    public function toWords(int $amount, string $currency, ?CurrencyTransformerOptions $options = null): string
    {
        $decimalPart = (int) ($amount / 100);
        $fractionalPart = abs($amount % 100);

        if ($fractionalPart === 0) {
            return trim($this->toCurrencyWords($currency, $decimalPart));
        }

        return trim($this->toCurrencyWords($currency, $decimalPart, $fractionalPart));
    }

    protected function toCurrencyWords($currency, $decimal, $fraction = null)
    {
        $currency = strtoupper($currency);

        $this->checkCurrencySupport($currency);

        $this->dictionary = new SpanishDictionary();
        $this->transformer = new SpanishConverter($this->dictionary);

        //change digit "one" to the short version see: https://www.rae.es/dpd/una
        SpanishDictionary::$units[1] = 'un';

        $currencyNames = SpanishDictionary::$currencyNames[$currency];

        $words = [];

        array_push($words, $this->dictionary->wordSeparator . trim($this->transformer->convert($decimal)));
        array_push($words, $this->dictionary->wordSeparator . $this->correspondingCurrency($currencyNames, $this->level($decimal)));
        array_push($words, $this->correspondingfraction($currencyNames, $fraction));

        //Go back digit "one"
        SpanishDictionary::$units[1] = 'uno';

        return implode('', $words);
    }

    private function checkCurrencySupport($currency)
    {
        if (!array_key_exists($currency, SpanishDictionary::$currencyNames)) {
            throw new NumberToWordsException(
                sprintf('Currency "%s" is not available for "%s" language', $currency, get_class($this))
            );
        }
    }

    private function correspondingCurrency($currencyNames, $level)
    {   
        if (! $level) {
            return $currencyNames[0][0];
        }

        return count($currencyNames[0]) > 1 
            ? $currencyNames[0][$level]
            : $currencyNames[0][0] . 's';
    }

    private function correspondingfraction($currencyNames, $fraction)
    {
        if (is_null($fraction)) {
            return;
        }

        $words = [];

        array_push($words, $this->dictionary->wordSeparator . 'con');
        array_push($words, $this->dictionary->wordSeparator . trim($this->transformer->convert($fraction)));

        if (! $this->level($fraction)) {
            array_push($words, $this->dictionary->wordSeparator . $currencyNames[1][0]);
            return implode('', $words);
        }

        count($currencyNames[1]) > 1 
            ? array_push($words, $this->dictionary->wordSeparator . $currencyNames[1][$this->level($fraction)])
            : array_push($words, $this->dictionary->wordSeparator . $currencyNames[1][0] . 's');
   
        return implode('', $words);
    }

    private function level($value)
    {
        return $value == 1 ? 0 : 1;
    }
}
