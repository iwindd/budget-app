<?php

namespace App\Services;

use Carbon\Carbon;

class FormatHelperService
{
    private static $BAHT_TEXT_NUMBERS = ['ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
    private static $BAHT_TEXT_UNITS = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
    private static $BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
    private static $BAHT_TEXT_TWENTY = 'ยี่';
    private static $BAHT_TEXT_INTEGER = 'ถ้วน';
    private static $BAHT_TEXT_BAHT = 'บาท';
    private static $BAHT_TEXT_SATANG = 'สตางค์';
    private static $BAHT_TEXT_POINT = 'จุด';

    public static function date($date, $format = 'd F Y', $lang = 'th')
    {
        Carbon::setLocale($lang);
        $carbonDate = Carbon::parse($date);
        $buddhistYear = $carbonDate->year + 543;
        $customFormat = str_replace('Y', $buddhistYear, $format);

        return $carbonDate->translatedFormat($customFormat);
    }

    public static function number($val, $decimals = 0)
    {
        return number_format($val, $decimals);
    }

    public static function bahtText($number, $include_unit = true, $display_zero = true)
    {
        if (!is_numeric($number)) {
            return null;
        }

        // Split the number into integer and decimal parts
        $numberParts = explode('.', number_format($number, 2, '.', ''));
        $integerPart = (int)$numberParts[0];
        $satangPart = isset($numberParts[1]) ? (int)$numberParts[1] : 0;

        $text = '';

        // Handle zero case
        if ($display_zero && $integerPart == 0) {
            $text = self::$BAHT_TEXT_NUMBERS[0];
        } else {
            $text .= self::convertIntegerToBahtText($integerPart);
        }

        if ($include_unit) {
            $text .= self::$BAHT_TEXT_BAHT;
            if ($satangPart > 0) {
                $text .= self::convertIntegerToBahtText($satangPart) . self::$BAHT_TEXT_SATANG;
            } else {
                $text .= self::$BAHT_TEXT_INTEGER;
            }
        } else {
            if ($satangPart > 0) {
                $text .= self::$BAHT_TEXT_POINT . self::convertIntegerToBahtText($satangPart);
            }
        }

        return $text;
    }

    private static function convertIntegerToBahtText($number)
    {
        if ($number == 0) {
            return '';
        }

        $numberStr = (string)$number;
        $text = '';
        $unit = 0;

        for ($i = strlen($numberStr) - 1; $i >= 0; $i--) {
            $currentNumber = (int)$numberStr[$i];

            if ($currentNumber > 0) {
                if ($unit == 1 && $currentNumber == 1 && $i > 0) {
                    $text = self::$BAHT_TEXT_ONE_IN_TENTH . $text;
                } else {
                    if ($unit == 1 && $currentNumber == 2) {
                        $text = self::$BAHT_TEXT_TWENTY . $text;
                    } else {
                        $text = self::$BAHT_TEXT_NUMBERS[$currentNumber] . self::$BAHT_TEXT_UNITS[$unit] . $text;
                    }
                }
            }

            $unit++;
        }

        return $text;
    }
}