<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\CardInquiryRequest;
use Omnipay\Iyzico\Message\CardInquiryResponse;
use Omnipay\Iyzico\Message\CreateCardRequest;
use Omnipay\Iyzico\Message\CreateCardResponse;
use Omnipay\Iyzico\Message\CreateLinkRequest;
use Omnipay\Iyzico\Message\CreateLinkResponse;
use Omnipay\Iyzico\Models\CardInquiryRequestModel;
use Omnipay\Iyzico\Models\CardInquiryResponseModel;
use Omnipay\Iyzico\Models\CardModel;
use Omnipay\Iyzico\Models\CreateCardRequestModel;
use Omnipay\Iyzico\Models\CreateCardResponseModel;
use Omnipay\Iyzico\Models\CreateLinkRequestModel;
use Omnipay\Iyzico\Models\CreateLinkResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class CreateLinkTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_create_link_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/CreateLinkRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CreateLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new CreateLinkRequestModel([
				'clientIp'        => '127.0.0.1',
				'name'            => 'Müşteri Ad',
				'surname'         => 'Müşteri Soyad',
				'tcCertificate'   => '11111111111',
				'taxNumber'       => NULL,
				'email'           => 'mail@example.com',
				'gsm'             => '5881231212',
				'amount'          => 100,
				'threeD'          => 'true',
				'expireDate'      => '2021-09-25 23:59:59',
				'installmentList' => NULL,
				'sendEmail'       => true,
				'mode'            => 'T',
				'commissionType'  => 1,
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:B4w7+0u0nHI/9VCYd7PTgaE3qDk=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_create_link_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/CreateLinkRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CreateLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_create_link_response()
	{
		$httpResponse = $this->getMockHttpResponse('CreateLinkResponseSuccess.txt');

		$response = new CreateLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new CreateLinkResponseModel([
			'result'          => 1,
			'errorCode'       => NULL,
			'errorMessage'    => NULL,
			'responseMessage' => 'Ödeme linki başarı ile gönderilmiştir.',
			'link'            => 'https://portal.ipara.com/faces/payment/transaction_link_payment.jsf?linkToken=0024Mb0yCb9lIXmGJz3C4xufw%3D%3D',
			'linkPaymentId'   => '002c/oQdJhkx4rgzWi2n87nVg==',
			'amount'          => '100',
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_create_link_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('CreateLinkResponseApiError.txt');

		$response = new CreateLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new CreateLinkResponseModel([
			'result'          => 0,
			'responseMessage' => 'Lütfen soyadınızı giriniz.',
			'errorCode'       => 847,
			'errorMessage'    => 'Lütfen soyadınızı giriniz.',
		]);

		$this->assertEquals($expected, $data);
	}
}
