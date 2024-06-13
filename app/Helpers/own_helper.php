<?php
if(!function_exists('dynamicMoney')){
    function dynamicMoney($amount, $locale = null, $currencyCode = null, $digit = false)
    {
        if($amount == '' || $amount == null){
            $amount = 0;
        }
        $pos = strpos($amount, '.');
        if ($pos !== false) {
            $amount = substr($amount, 0, $pos + 4);
        }
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        if($digit == true){
            $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 3);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 3);
        }else{
            $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0); 
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 0);
        }
        $formatted_amount = $formatter->formatCurrency($amount, $currencyCode);

        // $formatted_amount = $formatter->formatCurrency($amount, 'IDR');
        $dataLength = strlen($formatted_amount);
        $reduce = $dataLength - 4;
        $leading = substr($formatted_amount, 0, $reduce);
        $trailing = substr($formatted_amount, $reduce + 1, $dataLength);
        $replace = str_replace('.', ',', $leading);
        $fixAmount = $replace . '.' . $trailing;
        if($amount == 0){
            $fixAmount = $formatted_amount;
        }
        return $fixAmount;
    }
}


if (!function_exists('format_date')) {
    
    function format_date(string $date, string $format, string $timezone = 'Asia/Manila'): string
    {
        $dateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $date, new DateTimeZone('UTC'));
        
        if ($dateTime === false) {
            return 'Invalid date';
        }
        
        $targetTimezone = new DateTimeZone($timezone);
        $dateTime->setTimezone($targetTimezone);
        
        return $dateTime->format($format);
    }
}

