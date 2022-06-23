<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Message\ChargeRequest;
use Omnipay\Iyzico\Message\ChargeResponse;
use Omnipay\Iyzico\Models\AddressModel;
use Omnipay\Iyzico\Models\ChargeRequestModel;
use Omnipay\Iyzico\Models\InvoiceAddressModel;
use Omnipay\Iyzico\Models\ProductModel;
use Omnipay\Iyzico\Models\PurchaserModel;
use Omnipay\Iyzico\Models\ResponseModel;
use Omnipay\Iyzico\Tests\TestCase;

class ChargeTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();


	}

	public function test_charge_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ChargeRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new ChargeRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new ChargeRequestModel([
				'threeD'           => false,
				'threeDSecureCode' => '',
				'mode'             => 'T',
				'orderId'          => '6128e5cbf324c6128e5cbf3253',
				'cardOwnerName'    => 'Example User',
				'cardNumber'       => '5456165456165454',
				'cardExpireMonth'  => '12',
				'cardExpireYear'   => '24',
				'cardCvc'          => '000',
				'userId'           => NULL,
				'cardId'           => NULL,
				'installment'      => 1,
				'amount'           => '60000',
				'echo'             => NULL,
				'vendorId'         => NULL,
				'purchaser'        => new PurchaserModel([
					'name'            => 'Example',
					'surname'         => 'User',
					'email'           => 'required-dummy@email.com',
					'clientIp'        => '127.0.0.1',
					'birthDate'       => '1950-01-01',
					'gsmNumber'       => '5554443322',
					'tcCertificate'   => '11111111111',
					'invoiceAddress'  => new InvoiceAddressModel([
						'tcCertificate' => NULL,
						'taxNumber'     => NULL,
						'taxOffice'     => NULL,
						'companyName'   => NULL,
						'name'          => 'Example',
						'surname'       => 'User',
						'address'       => '123 Billing St Billsville',
						'zipcode'       => '12345',
						'city'          => 'Billstown',
						'country'       => 'TR',
						'phoneNumber'   => '5554443322',
					]),
					'shippingAddress' => new AddressModel([
						'name'        => 'Example',
						'surname'     => 'User',
						'address'     => '123 Shipping St Shipsville',
						'zipcode'     => '54321',
						'city'        => 'Shipstown',
						'country'     => 'TR',
						'phoneNumber' => '5554443322',
					]),
				]),
				'products'         => [
					new ProductModel([
						'productCode' => 'c7813278bc7fb6312ce59900eebf2720ca875293',
						'productName' => 'Perspiciatis et facilis tempore facilis.',
						'quantity'    => 6,
						'price'       => 100,
					]),
				],
			]),
			'headers'        => [
				'transactionDate' => "2021-08-27 16:17:02",
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:+/GdtUUZfdAAu7p/061QaoOsgnA=',
			],
		];

		self::assertSame(json_encode($expected), json_encode($data));
	}

	public function test_charge_request_saved_card()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ChargeRequest-SavedCard.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new ChargeRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new ChargeRequestModel([
				'threeD'           => false,
				'threeDSecureCode' => '',
				'mode'             => 'T',
				'orderId'          => '6128e5cbf324c6128e5cbf3253',
				'cardOwnerName'    => 'Example User',
				'cardNumber'       => null,
				'cardExpireMonth'  => null,
				'cardExpireYear'   => null,
				'cardCvc'          => null,
				'userId'           => "5KKD0",
				'cardId'           => "4DCZZ",
				'installment'      => 1,
				'amount'           => '60000',
				'echo'             => NULL,
				'vendorId'         => NULL,
				'purchaser'        => new PurchaserModel([
					'name'            => 'Example',
					'surname'         => 'User',
					'email'           => 'required-dummy@email.com',
					'clientIp'        => '127.0.0.1',
					'birthDate'       => '1950-01-01',
					'gsmNumber'       => '5554443322',
					'tcCertificate'   => '11111111111',
					'invoiceAddress'  => new InvoiceAddressModel([
						'tcCertificate' => NULL,
						'taxNumber'     => NULL,
						'taxOffice'     => NULL,
						'companyName'   => NULL,
						'name'          => 'Example',
						'surname'       => 'User',
						'address'       => '123 Billing St Billsville',
						'zipcode'       => '12345',
						'city'          => 'Billstown',
						'country'       => 'TR',
						'phoneNumber'   => '5554443322',
					]),
					'shippingAddress' => new AddressModel([
						'name'        => 'Example',
						'surname'     => 'User',
						'address'     => '123 Shipping St Shipsville',
						'zipcode'     => '54321',
						'city'        => 'Shipstown',
						'country'     => 'TR',
						'phoneNumber' => '5554443322',
					]),
				]),
				'products'         => [
					new ProductModel([
						'productCode' => 'c7813278bc7fb6312ce59900eebf2720ca875293',
						'productName' => 'Perspiciatis et facilis tempore facilis.',
						'quantity'    => 6,
						'price'       => 100,
					]),
				],
			]),
			'headers'        => [
				'transactionDate' => "2021-08-27 16:17:02",
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:CHWK7bhBYHRzI/74Fy+maWvnZ7M=',
			],
		];

		self::assertSame(json_encode($expected), json_encode($data));
	}

	public function test_charge_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ChargeRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new ChargeRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidCreditCardException::class);

		$request->getData();
	}

	public function test_charge_response()
	{
		$httpResponse = $this->getMockHttpResponse('ChargeResponseSuccess.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		/** @var ChargeResponse $response */
		$response = new ChargeResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$this->assertEquals(new ResponseModel([
			"amount"           => "60000",
			"echo"             => "",
			"errorCode"        => "",
			"errorMessage"     => "",
			"hash"             => "o9pDvOIxsTQBYy8K3e78NdxA6W0=",
			"mode"             => "T",
			"orderId"          => "6128e5cbf324c6128e5cbf3253",
			"publicKey"        => $this->public_key,
			"result"           => "1",
			"transactionDate"  => "2021-08-27 16:17:02",
			"commissionRate"   => null,
			"threeDSecureCode" => null,
		]), $data);
	}

	public function test_charge_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('ChargeResponseApiError.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		$response = new ChargeResponse($this->getMockRequest(), $httpResponse);

		$this->assertFalse($response->isSuccessful());

		$this->assertEquals("964", $response->getCode());

		$this->assertEquals("Ödeme işleminizde kullanmış olduğunuz kart güvenlik sebebiyle engellenmiştir.", $response->getMessage());
	}
}
