<?php


namespace App\Lib;


class Helper
{
    //소수점 자르기
    public static function decimalScale($val, $scale = 0) {
        if(!$val) return $val;

        $result = bcadd($val, 0, $scale);

        return $result;
    }

    // 삼항연산자
    public static function ternaryOperator($val, $comparisonTarget, $a, $b) {
        $result = $val == $comparisonTarget ? $a : $b;

        return $result;
    }

    //숫자 형식만 , 특수문자 제거, 앞뒤 공백 제거
    public static function specailSignReplace($val, $a = ',') {
        $val = $val ?? 0;
        $result = trim($val);
        $result = str_replace($a, '', $result);

        return $result;
    }
}
