<?php

namespace Omnipay\Iyzico\Helpers;

use Omnipay\Iyzico\Models\InstallmentDetailModel;
use Omnipay\Iyzico\Models\InstallmentPriceModel;

class Helper
{
    /**
     * @param $input
     * @param $var
     */
    public static function format_binNumber($input, &$var)
    {
        $var = substr($input, 0, 6);
    }

    /**
     * @param $input
     * @param $var
     */
    public static function format_price($price, &$var)
    {
        $price = number_format($price, 2, '.', '');

        if (!str_contains($price, ".")) {
            $var = $price . ".0";
        }

        $subStrIndex = 0;

        $priceReversed = strrev($price);

        for ($i = 0, $iMax = strlen($priceReversed); $i < $iMax; $i++) {

            if (strcmp($priceReversed[$i], "0") == 0) {
                $subStrIndex = $i + 1;
            } else if (strcmp($priceReversed[$i], ".") == 0) {
                $priceReversed = "0" . $priceReversed;
                break;
            } else {
                break;
            }

        }

        $var = strrev(substr($priceReversed, $subStrIndex));

    }

    /**
     * @param $input
     * @param $var
     */
    public static function format_cardExpireMonth($input, &$var)
    {
        $var = str_pad($input, 2, '0', STR_PAD_LEFT);
    }

    public function format_commercial($input, &$var)
    {
        $var = filter_var($input, FILTER_VALIDATE_BOOL);
    }

    public function format_forceCvc($input, &$var)
    {
        $var = filter_var($input, FILTER_VALIDATE_BOOL);
    }

    public function format_force3ds($input, &$var)
    {
        $var = filter_var($input, FILTER_VALIDATE_BOOL);
    }

    public static function hash(?string $publicKey, string $privateKey, array $appends, string $random_string): string
    {
        $append  = array_map(fn($key) => "$key=$appends[$key]", array_keys($appends));
        $hashStr = $publicKey . $random_string . $privateKey . "[" . implode(",", $append) . "]";

        return base64_encode(sha1($hashStr, true));
    }

    public static function prettyPrint($data)
    {
        echo "<pre>" . print_r($data, true) . "</pre>";
    }

    public static function format_installmentDetails($input, &$var)
    {

        $var = [];

        foreach ($input as $i) {

            $var[] = new InstallmentDetailModel($i);

        }

    }

    public static function format_installmentPrices($input, &$var)
    {

        $var = [];

        foreach ($input as $i) {

            $var[] = new InstallmentPriceModel($i);

        }

    }
}
