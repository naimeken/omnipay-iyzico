<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Message\EnrolmentRequest;
use Omnipay\Iyzico\Message\EnrolmentResponse;
use Omnipay\Iyzico\Models\AddressModel;
use Omnipay\Iyzico\Models\EnrolmentRequestModel;
use Omnipay\Iyzico\Models\InvoiceAddressModel;
use Omnipay\Iyzico\Models\ProductModel;
use Omnipay\Iyzico\Models\PurchaserModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class EnrolmentTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();


	}

	public function test_enrolment_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/EnrolmentRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new EnrolmentRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new EnrolmentRequestModel([
				'threeD'           => true,
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
				'transactionDate'  => '2021-08-27 16:17:02',
				'token'            => "ZZZZZ3333333333:P8fT0qom2wR56Ge8M95IaQZxMSE=",
				"successUrl"       => "https://iparatest.com/omnipay/ipara/usage/3d-success.php",
				"failureUrl"       => "https://iparatest.com/omnipay/ipara/usage/3d-failure.php",
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
						'price'       => "100",
					]),
				],
			]),
			'headers'        => new RequestHeadersModel([
				'transactionDate' => "2021-08-27 16:17:02",
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:+/GdtUUZfdAAu7p/061QaoOsgnA=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_enrolment_request_saved_card()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/EnrolmentRequest-SavedCard.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new EnrolmentRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new EnrolmentRequestModel([
				'threeD'           => true,
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
				'transactionDate'  => '2021-08-27 16:17:02',
				'token'            => "ZZZZZ3333333333:CHWK7bhBYHRzI/74Fy+maWvnZ7M=",
				"successUrl"       => "https://iparatest.com/omnipay/ipara/usage/3d-success.php",
				"failureUrl"       => "https://iparatest.com/omnipay/ipara/usage/3d-failure.php",
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
						'price'       => "100",
					]),
				],
			]),
			'headers'        => new RequestHeadersModel([
				'transactionDate' => "2021-08-27 16:17:02",
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:CHWK7bhBYHRzI/74Fy+maWvnZ7M=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_enrolment_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/EnrolmentRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new EnrolmentRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidCreditCardException::class);

		$request->getData();
	}

	public function test_enrolment_response()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/EnrolmentRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new EnrolmentRequest($this->getHttpClient(), $this->getHttpRequest());

		/** @var EnrolmentResponse $response */
		$response = $request->initialize($options)->send();

		$data = $response->getRedirectData();

		$this->assertFalse($response->isSuccessful());

		$this->assertTrue($response->isRedirect());

		$this->assertArrayHasKey("parameters", $data);

		$this->assertEquals([
			"parameters" => htmlspecialchars(json_encode($request->getData()["request_params"]))
		], $data);
	}
}
