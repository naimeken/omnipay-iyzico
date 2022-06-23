<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\CaptureRequest;
use Omnipay\Iyzico\Message\CaptureResponse;
use Omnipay\Iyzico\Models\CaptureRequestModel;
use Omnipay\Iyzico\Models\CaptureResponseModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class CaptureTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_capture_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/CaptureRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new CaptureRequestModel([
				'mode'     => 'T',
				'orderId'  => '',
				'amount'   => 60000,
				'clientIp' => '127.0.0.1',
				'name'     => 'Example',
				'surname'  => 'User',
				'email'    => 'mail@example.com',
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:xTCQuSdUi61xDbDYszeobOKtOTU=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_capture_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ChargeRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_capture_response()
	{
		$httpResponse = $this->getMockHttpResponse('CaptureResponseSuccess.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		$response = new CaptureResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$this->assertEquals(new CaptureResponseModel([
			"result"          => "1",
			"orderId"         => "6128e5cbf324c6128e5cbf3253",
			"amount"          => "60000",
			"mode"            => "T",
			"publicKey"       => $this->public_key,
			"echo"            => "",
			"errorCode"       => "",
			"errorMessage"    => "",
			"transactionDate" => "2021-08-27 16:17:02",
			"hash"            => "o9pDvOIxsTQBYy8K3e78NdxA6W0=",
		]), $data);
	}

	public function test_charge_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('CaptureResponseApiError.txt');

		$this->getMockRequest()->shouldReceive("getParameters")->twice()->andReturn([
			"publicKey"  => $this->public_key,
			"privateKey" => $this->private_key
		]);

		$response = new CaptureResponse($this->getMockRequest(), $httpResponse);

		$expected = new CaptureResponseModel([
			'result'          => 0,
			'orderId'         => '6128e5cbf324c6128e5cbf3253',
			'amount'          => 60000,
			'mode'            => 'T',
			'publicKey'       => 'ZZZZZ3333333333',
			'echo'            => '',
			'errorCode'       => 1000,
			'errorMessage'    => 'İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
			'transactionDate' => '2021-08-27 16:17:02',
			'hash'            => 'xnPFBFyqIHpYm4pbxUIIWciOMJk=',
		]);

		$this->assertFalse($response->isSuccessful());

		$this->assertEquals($expected, $response->getData());
	}
}
