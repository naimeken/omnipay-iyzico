<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\DeleteLinkRequest;
use Omnipay\Iyzico\Message\DeleteLinkResponse;
use Omnipay\Iyzico\Models\DeleteLinkRequestModel;
use Omnipay\Iyzico\Models\DeleteLinkResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class DeleteLinkTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_delete_link_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/DeleteLinkRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new DeleteLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new DeleteLinkRequestModel([
				'linkId'   => '002+9zCZLoFwrwYOq7+rt36kg==',
				'clientIp' => '127.0.0.1',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:Jm8/SVMepcRN3GuQI+oN3akb8tc=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_delete_link_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/DeleteLinkRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new DeleteLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_delete_link_response()
	{
		$httpResponse = $this->getMockHttpResponse('DeleteLinkResponseSuccess.txt');

		$response = new DeleteLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new DeleteLinkResponseModel([
			'result'          => 1,
			'responseMessage' => 'Ödeme link kaydı başarılı bir şekilde silindi.',
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_delete_link_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('DeleteLinkResponseApiError.txt');

		$response = new DeleteLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new DeleteLinkResponseModel([
			'result'          => 0,
			'responseMessage' => 'İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
			'errorCode'       => 3166,
			'errorMessage'    => 'Ödeme Linki kayıtlarının silinmesi işlemi için gelen istekte silinecek kayıt bilgisi tanımlanamadı.',
		]);

		$this->assertEquals($expected, $data);
	}
}
