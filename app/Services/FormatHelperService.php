<?php

namespace App\Services;

use App\Models\BudgetItem;
use Carbon\Carbon;
use PA\ProvinceTh\Factory;

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
        if (strpos($format, 'y') !== false) {
            // แปลงปีคริสต์ศักราช (ค.ศ.) เป็นปีพุทธศักราช (พ.ศ.) แบบย่อ
            $buddhistYearShort = ($carbonDate->year + 543) % 100; // เหลือแค่ 2 หลักท้าย
            $customFormat = str_replace('y', $buddhistYearShort, $format);
        } else {
            // กรณีใช้ 'Y' เป็นปีแบบเต็ม พ.ศ.
            $buddhistYearFull = $carbonDate->year + 543;
            $customFormat = str_replace('Y', $buddhistYearFull, $format);
        }

        return $carbonDate->translatedFormat($customFormat);
    }

    public static function dateAddress($start, $end, $multiple = false, $options = [], $lang = 'th') {
        Carbon::setLocale($lang);
        $fromDate = Carbon::parse($start);
        $backDate = Carbon::parse($end);
        $isMultiple = !$fromDate->isSameDay($backDate) && $multiple;
        $isSameMonth = $fromDate->isSameMonth($backDate);
        $isSameYear = $fromDate->isSameYear($backDate);

        $dP = $options['Pd'] ?? '';
        $mP = $options['Pm'] ?? '';
        $yP = $options['Py'] ?? '';
        $tP = $options['Pt'] ?? '';
        $fM = $isSameMonth ? "$mP F" : "M";
        $fD = "$dP d";
        $fY = "$yP Y";
        $fT = "$tP H:i";

        if ($options['fMain']){
            $backDate->setTimeFromTimeString($fromDate->toTimeString());
        }else{
            $fromDate->setTimeFromTimeString($backDate->toTimeString());
        }

        if ($isMultiple){
            $format = "$fD";

            if (!$isSameMonth) $format = "$fD $fM";
            if (!$isSameYear) $format = "$fD $fM ";

            $_fromDate = self::date($fromDate, $format, $lang);
            $_backDate = self::date($backDate, "d $fM $fY $fT", $lang);

            return "$_fromDate - $_backDate";
        }else{
            return self::date(
                $options['fMain'] ? $fromDate : $backDate
            , "$fD $fM $fY $fT", $lang);
        }

    public static function dayDiff($date1, $date2, $absolute = true) {
        return Carbon::parse($date1)->diffInDays(Carbon::parse($date2), $absolute);
    }

    public static function dateDiffHumans($date, $lang = 'th') {
        Carbon::setLocale($lang);
        return Carbon::parse($date)->diffForHumans();
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

    public static function userName($val) {
        return $val ?? 'N/A';
    }

    public static function province($id) {
        return Factory::province()->find($id)['name_th'];
    }

    public static function role($role) {
        return trans("users.table-role-$role");
    }

    public static function isBudgetOwner($budget, $budgetItem) {
        return $budget->user_id == $budgetItem->user_id;
    }

    public static function getBudgetItemExpenseSum($budgetItem) {
        return BudgetItem::getBudgetExpenseTotal($budgetItem);
    }

    public static function getBudgetItemAddressSum($budgetItem) {
        $budgetFromBack = BudgetItem::getFromBack($budgetItem);

        $fromDate = Carbon::parse($budgetFromBack['from']);
        $backDate = Carbon::parse($budgetFromBack['back']);
        $diffInSeconds = $fromDate->diffInSeconds($backDate);

        $days = floor($diffInSeconds / (60 * 60 * 24));
        $hours = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));

        return [
            'days' => $days,
            'hours' => $hours
        ];
    }

    public static function isBudgetItemFinished($budgetItem) {
        return BudgetItem::isHasData($budgetItem);
    }
}
