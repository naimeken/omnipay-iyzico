<?php

namespace Omnipay\Iyzico\Helpers;

class Helper
{
	/**
	 * @param $input
	 * @param $var
	 */
	public static function format_cardExpireYear($input, &$var)
	{
		$var = substr($input, -2);
	}
	/**
	 * @param $input
	 * @param $var
	 */
	public static function format_gsm($input, &$var)
	{
		$var = substr(preg_replace("/(\D+)/", "", $input), -10);
	}

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
	public static function format_price($input, &$var)
	{
		$var = $input * 100;
	}

	/**
	 * @param $input
	 * @param $var
	 */
	public static function format_echo($input, &$var)
	{
		$var = substr($input, 0, 255);
	}

	/**
	 * @param $input
	 * @param $var
	 */
	public static function format_cardExpireMonth($input, &$var)
	{
		$var = str_pad($input, 2, '0', STR_PAD_LEFT);
	}

	/**
	 * @param $input
	 * @param $var
	 */
	public static function format_threeD($input, &$var)
	{
		$var = $input === false ? "false" : "true";
	}

	public static function hash(?string $public_key, string $hash_string): string
	{
		if ($public_key) {

			$public_key .= ':';

		}

		return $public_key . base64_encode(sha1($hash_string, true));
	}

	public static function prettyPrint($data)
	{
		echo "<pre>" . print_r($data, true) . "</pre>";
	}

	/**
	 * @param object|array $input
	 */
	public static function arrayUnsetRecursive(&$input)
	{
		foreach ($input as $key => $value) {

			if (is_array($value)) {

				self::arrayUnsetRecursive($value);

			} else if ($value === null) {

				if (is_object($input)) {

					unset($input->$key);

				} else {

					unset($input[$key]);

				}

			}

		}
	}
}
