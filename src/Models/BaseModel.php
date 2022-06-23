<?php

namespace Omnipay\Iyzico\Models;

use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Helpers\XmlDomConstruct;

class BaseModel
{
	public function __construct(?array $abstract)
	{
		foreach ($abstract as $key => $arg) {

			if (property_exists($this, $key)) {

				$this->$key = $arg;

			}

		}

		$this->formatFields();
	}

	private function formatFields()
	{
		$fields = ["cardExpireMonth", "cardExpireYear", "threeD", "binNumber", "echo", "gsm", "price"];

		foreach ($fields as $field) {

			if (!empty($this->$field)) {

				$func = "format_{$field}";

				Helper::$func($this->$field, $this->$field);

			}

		}
	}

	public function asXml($root_tag_name)
	{
		if ($root_tag_name) {

			$array = [$root_tag_name => json_decode(json_encode($this), 1)];

		} else {

			$array = json_decode(json_encode($this), 1);

		}

		if (isset($array["auth"]["products"])) {

			$array["auth"]["products"] = ["product" => $array["auth"]["products"]];

		}

		$dom = new XmlDomConstruct('1.0', 'utf-8');

		$dom->fromMixed($array);

		return $dom->saveXML();
	}
}
