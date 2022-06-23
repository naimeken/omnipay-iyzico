<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\LoginRequest;
use Omnipay\Iyzico\Message\LoginResponse;
use Omnipay\Iyzico\Models\LoginRequestModel;
use Omnipay\Iyzico\Models\LoginResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class LoginTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_login_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/LoginRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new LoginRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new LoginRequestModel([
				'clientIp'        => '127.0.0.1',
				'corporateNumber' => '227866',
				'username'        => 'ADMIN',
				'password'        => 'Aa123456',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:B2magC4UFMyCUi5EM0ydsozA6ig=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_login_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/LoginRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new LoginRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_login_response()
	{
		$httpResponse = $this->getMockHttpResponse('LoginResponseSuccess.txt');

		$response = new LoginResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new LoginResponseModel([
			'result'               => 1,
			'corporateMemberId'    => '006+eqFKQfrvY5r/5MxiarezQ==',
			'companyName'          => 'Multinet Kurumsal Hizmetler A.Ş.',
			'showVendorPages'      => 1,
			'showOosPages'         => 1,
			'showLinkPaymentPages' => 1,
			'sessionToken'         => 'c4a8163d-e563-4ad8-96c6-ba0e55cc71d9',
			'oosLink'              => 'https://entegrasyon.ipara.com/oos?d=006g%2BgcrF8aQzU3YHdSsv7M4oX%2FEPit07U2J%2BzEy4VBG8muyPsoTTrYv3QyNEhIyCKw',
			'showMarketPlacePages' => 0,
			'responseMessage'      => NULL,
			'errorCode'            => NULL,
			'errorMessage'         => NULL,
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_login_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('LoginResponseApiError.txt');

		$response = new LoginResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new LoginResponseModel([
			'result'          => 0,
			'responseMessage' => 'Giriş bilgileriniz hatalıdır.',
			'errorCode'       => 3043,
			'errorMessage'    => 'Giriş bilgileriniz hatalıdır.',
		]);

		$this->assertEquals($expected, $data);
	}
}
