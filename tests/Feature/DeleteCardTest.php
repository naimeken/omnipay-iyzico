<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\DeleteCardRequest;
use Omnipay\Iyzico\Message\DeleteCardResponse;
use Omnipay\Iyzico\Models\DeleteCardRequestModel;
use Omnipay\Iyzico\Models\DeleteCardResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class DeleteCardTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_delete_card_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/DeleteCardRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new DeleteCardRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new DeleteCardRequestModel([
				'userId'   => '612416047be0c612416047be0e',
				'cardId'   => '002zqRWEV7ZHElKLj9cKS+z2rvr7OH80ByWUeSWMnqMFzE=',
				'clientIp' => '127.0.0.1',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:PPe1XKCIEqd3KFt85RPcYJMyxUE=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_delete_card_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/DeleteCardRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new DeleteCardRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_delete_card_response()
	{
		$httpResponse = $this->getMockHttpResponse('DeleteCardResponseSuccess.txt');

		$response = new DeleteCardResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new DeleteCardResponseModel([
			'result'          => 1,
			'responseMessage' => 'Banka kartınız silinmiştir.',
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_delete_card_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('DeleteCardResponseApiError.txt');

		$response = new DeleteCardResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new DeleteCardResponseModel([
			'result'          => 0,
			'errorMessage'    => 'Kullanıcının kartı bulunamadı.',
			'errorCode'       => 970,
			'responseMessage' => 'İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
		]);

		$this->assertEquals($expected, $data);
	}
}
