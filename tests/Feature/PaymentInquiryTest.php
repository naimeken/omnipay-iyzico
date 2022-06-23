<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\PaymentInquiryRequest;
use Omnipay\Iyzico\Message\PaymentInquiryResponse;
use Omnipay\Iyzico\Models\PaymentInquiryRequestModel;
use Omnipay\Iyzico\Models\PaymentInquiryResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class PaymentInquiryTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_payment_inquiry_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/PaymentInquiryRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new PaymentInquiryRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new PaymentInquiryRequestModel([
				'mode'    => 'T',
				'orderId' => '61265b267c20561265b267c207',
				'echo'    => '',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:88Qle0bO8h0vMn5Akl3r1zAdzcg=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_payment_inquiry_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/PaymentInquiryRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new PaymentInquiryRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_payment_inquiry_response()
	{
		$httpResponse = $this->getMockHttpResponse('PaymentInquiryResponseSuccess.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		$response = new PaymentInquiryResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new PaymentInquiryResponseModel([
			'result'          => '1',
			'responseMessage' => 'APPROVED',
			'errorMessage'    => 'İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
			'errorCode'       => '1000',
			'publicKey'       => $this->public_key,
			'echo'            => [],
			'transactionDate' => '2021-08-28 17:42:30',
			'mode'            => 'T',
			'orderId'         => '6128e5cbf324c6128e5cbf3253',
			'amount'          => '60000',
			'hash'            => 'NPd3qMtTNwqe+h105Pe08MzTnRM=',
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_payment_inquiry_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('PaymentInquiryResponseApiError.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		$response = new PaymentInquiryResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new PaymentInquiryResponseModel([
			'result'          => '0',
			'responseMessage' => NULL,
			'errorMessage'    => 'Sipariş numarası boş olamaz.',
			'errorCode'       => '814',
			'publicKey'       => $this->public_key,
			'echo'            => [],
			'transactionDate' => '2021-08-28 18:05:39',
			'mode'            => 'T',
			'orderId'         => [],
			'amount'          => NULL,
			'hash'            => 'VzIFC0GdtIndfyvJZD4oHJyCwlY=',
		]);

		$this->assertEquals($expected, $data);
	}
}
