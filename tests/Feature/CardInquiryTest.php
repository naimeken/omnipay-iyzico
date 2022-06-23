<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\CardInquiryRequest;
use Omnipay\Iyzico\Message\CardInquiryResponse;
use Omnipay\Iyzico\Models\CardInquiryRequestModel;
use Omnipay\Iyzico\Models\CardInquiryResponseModel;
use Omnipay\Iyzico\Models\CardModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class CardInquiryTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_card_inquiry_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/CardInquiryRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CardInquiryRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new CardInquiryRequestModel([
				'userId'   => '612416047be0c612416047be0e',
				'cardId'   => '',
				'clientIp' => '127.0.0.1',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => "2021-08-27 16:17:02",
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:qVOYBNc9UrI+wCfh03uPMlQpL/I=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_card_inquiry_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/CardInquiryRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CardInquiryRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_card_inquiry_response()
	{
		$httpResponse = $this->getMockHttpResponse('CardInquiryResponseSuccess.txt');

		$response = new CardInquiryResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new CardInquiryResponseModel([
			"result"       => 1,
			"errorCode"    => null,
			"errorMessage" => null,
			"cards"        => [
				new CardModel([
					"cardId"                => "002DNiTi6q55TqJ3h91frC/+CwVicTIQLdXRaWZFXH69cM=",
					"maskNumber"            => "545616******5454",
					"alias"                 => "Test Card Alias",
					"bankId"                => 111,
					"bankName"              => "Finansbank",
					"cardFamilyName"        => "CARD FINANS",
					"supportsInstallment"   => 0,
					"supportedInstallments" => [1],
					"type"                  => 1,
					"serviceProvider"       => 1,
					"threeDSecureMandatory" => 1,
					"cvcMandatory"          => 1,
				]),
			],
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_card_inquiry_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('CardInquiryResponseApiError.txt');

		$response = new CardInquiryResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new CardInquiryResponseModel([
			"result"          => 0,
			"errorMessage"    => "Client IP alanı boş olamaz.",
			"responseMessage" => "İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",
			"errorCode"       => 852,
			"cards"           => null,
		]);

		$this->assertEquals($expected, $data);
	}
}
