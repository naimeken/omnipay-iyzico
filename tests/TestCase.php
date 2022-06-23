<?php

namespace Omnipay\Iyzico\Tests;

use Faker\Factory;
use Omnipay\Iyzico\Gateway;
use Omnipay\Tests\GatewayTestCase;

class TestCase extends GatewayTestCase
{
	public $faker;

	public $public_key = "ZZZZZ3333333333";

	public $private_key = "ZZZZZ3333333333Z3ZZ3333Z3";

	public $order_id = "6128e5cbf324c6128e5cbf3253";

	public $transaction_date = "2021-08-27 16:17:02";

	public function setUp(): void
	{
		parent::setUp();

		$this->faker = Factory::create("tr_TR");

		$this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
	}
}
