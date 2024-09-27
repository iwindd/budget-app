<?php
namespace App\Services;

use Carbon\Carbon;
class FormatHelperService
{
    public static function date($date, $format = 'd F Y', $lang = 'th')
    {
        Carbon::setLocale($lang);
        $carbonDate = Carbon::parse($date);
        $buddhistYear = $carbonDate->year + 543;
        $customFormat = str_replace('Y', $buddhistYear, $format);

        return $carbonDate->translatedFormat($customFormat);
    }
}
