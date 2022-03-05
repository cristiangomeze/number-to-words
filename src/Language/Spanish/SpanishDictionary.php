<?php

namespace NumberToWords\Language\Spanish;

use NumberToWords\Language\Dictionary;

class SpanishDictionary implements Dictionary
{
    public const LOCALE = 'es';
    public const LANGUAGE_NAME = 'Spanish';
    public const LANGUAGE_NAME_NATIVE = 'Español';

    public $wordSeparator = ' ';

    public static array $units = [
        'cero',
        'uno',
        'dos',
        'tres',
        'cuatro',
        'cinco',
        'seis',
        'siete',
        'ocho',
        'nueve'
    ];

    private static array $teens = [
        'diez',
        'once',
        'doce',
        'trece',
        'catorce',
        'quince',
        'dieciseis',
        'diecisiete',
        'dieciocho',
        'diecinueve'
    ];

    private static array $tens = [
        '',
        'diez',
        'veinte',
        'treinta',
        'cuarenta',
        'cincuenta',
        'sesenta',
        'setenta',
        'ochenta',
        'noventa'
    ];

    private static array $hundreds = [
        '',
        'ciento',
        'doscientos',
        'trescientos',
        'cuatrocientos',
        'quinientos',
        'seiscientos',
        'setecientos',
        'ochocientos',
        'novecientos'
    ];

    public static $exponent = [
        0 => ['', ''],
        3 => ['mil', 'mil'],
        6 => ['millón', 'millones'],
        12 => ['billón', 'billones'],
        18 => ['trilón', 'trillones'],
        24 => ['cuatrillón', 'cuatrillones'],
        30 => ['quintillón', 'quintillones'],
        36 => ['sextillón', 'sextillones'],
        42 => ['septillón', 'septillones'],
        48 => ['octallón', 'octallones'],
        54 => ['nonallón', 'nonallones'],
        60 => ['decallón', 'decallones'],
    ];

    public static $currencyNames = [
        'PEN' => [['sol', 'soles'], ['centavo']],
        'ALL' => [['lek'], ['qindarka']],
        'AUD' => [['dólar australiano', 'dólares australianos'], ['centavo']],
        'ARS' => [['peso'], ['centavo']],
        'BAM' => [['convertible marka'], ['fenig']],
        'BGN' => [['lev'], ['stotinka']],
        'BRL' => [['real', 'reales'], ['centavo']],
        'BYR' => [['rublo bielorruso', 'rublos bielorrusos'], ['kopek', 'kopeks']],
        'CAD' => [['dólar canadiense', 'dólares canadienses'], ['centavo']],
        'CHF' => [['swiss franc'], ['rapp']],
        'CYP' => [['cypriot pound'], ['cent']],
        'CZK' => [['czech koruna'], ['halerz']],
        'CRC' => [['colón', 'colones'], ['centavo']],
        'DZD' => [['dinar', 'dinares'], ['céntimo']],
        'DKK' => [['danish krone'], ['ore']],
        'DOP' => [['peso dominicano', 'pesos dominicanos'], ['centavo', 'centavos']],
        'EEK' => [['kroon'], ['senti']],
        'EUR' => [['euro'], ['centavo']],
        'GBP' => [['libra'], ['peñique']],
        'HKD' => [['dólar de hong kong', 'dólares de hong kong'], ['centavo']],
        'HRK' => [['croatian kuna'], ['lipa']],
        'HUF' => [['forint'], ['filler']],
        'ILS' => [['new sheqel', 'new sheqels'], ['agora', 'agorot']],
        'ISK' => [['icelandic króna'], ['aurar']],
        'JPY' => [['yen', 'yenes'], ['sen']],
        'LTL' => [['litas'], ['cent']],
        'LVL' => [['lat'], ['sentim']],
        'LYD' => [['dinar', 'dinares'], ['céntimo']],
        'MAD' => [['dírham'], ['céntimo']],
        'MKD' => [['denar macedonio', 'denares macedonios'], ['deni']],
        'MRO' => [['ouguiya'], ['khoums']],
        'MTL' => [['lira maltesa'], ['céntimo']],
        'MXN' => [['peso'], ['centavo']],
        'NOK' => [['norwegian krone'], ['oere']],
        'PLN' => [['zloty', 'zlotys'], ['grosz']],
        'ROL' => [['romanian leu'], ['bani']],
        'RUB' => [['rublo ruso', 'rublos rusos'], ['kopek']],
        'SEK' => [['Swedish krona'], ['oere']],
        'SIT' => [['tolar'], ['stotinia']],
        'SKK' => [['slovak koruna'], []],
        'TND' => [['dinar', 'dinares'], ['céntimo']],
        'TRL' => [['lira'], ['kuruþ']],
        'UAH' => [['hryvna'], ['cent']],
        'USD' => [['dólar', 'dólares'], ['centavo']],
        'UYU' => [['peso uruguayo', 'pesos uruguayos'], ['centavo']],
        'VEB' => [['bolívar', 'bolívares'], ['céntimo']],
        'XAF' => [['franco CFA', 'francos CFA'], ['céntimo']],
        'XOF' => [['franco CFA', 'francos CFA'], ['céntimo']],
        'YUM' => [['dinar', 'dinares'], ['para']],
        'ZAR' => [['rand'], ['cent']]
    ];

    public function getZero(): string
    {
        return self::$units[0];
    }

    public function getMinus(): string
    {
        return 'menos';
    }

    public function getCorrespondingUnit(int $unit): string
    {
        return self::$units[$unit];
    }

    public function getCorrespondingTen(int $ten): string
    {
        return self::$tens[$ten];
    }

    public function getCorrespondingTeen(int $teen): string
    {
        return self::$teens[$teen];
    }

    public function getCorrespondingHundred(int $hundred): string
    {
        return self::$hundreds[$hundred];
    }
}