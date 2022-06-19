<?php namespace App\helpers;

class GeneralHelper {
    public static function make_nice_array_for_overview(array $a)
    {
        foreach ($a as $key => $value) {
            $tmp_date = date('Y-m-d', strtotime($value->date));
            $a[$key]->date = $tmp_date;

            //$tmp_amount = number_format($value->amount, 2);
            //$a[$key]->amount = $tmp_amount;
        }

        return $a;
    }
}
