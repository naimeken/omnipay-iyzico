<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\PaymentSearchRequest;
use Omnipay\Iyzico\Message\PaymentSearchResponse;
use Omnipay\Iyzico\Models\LinkPaymentRecordModel;
use Omnipay\Iyzico\Models\PaymentModel;
use Omnipay\Iyzico\Models\PaymentSearchRequestModel;
use Omnipay\Iyzico\Models\PaymentSearchResponseModel;
use Omnipay\Iyzico\Models\CardModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class PaymentSearchTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_payment_search_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/PaymentSearchRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new PaymentSearchRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new PaymentSearchRequestModel([
				"mode"      => "T",
				"startDate" => "2021-08-01 23:59:59",
				"endDate"   => "2021-08-30 23:59:59",
				"echo"      => "",
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:AbTHvEq1RXpg2vXAwx+VXlnbJBk=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_payment_search_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/PaymentSearchRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new PaymentSearchRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_payment_search_response()
	{
		$httpResponse = $this->getMockHttpResponse('PaymentSearchResponseSuccess.txt');

		$response = new PaymentSearchResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new PaymentSearchResponseModel([
			'result'          => 1,
			'responseMessage' => 'SUCCESS',
			'totalPayments'   => 4,

			'payments' => [
				new PaymentModel([
					'result'          => '1',
					'responseMessage' => 'APPROVED',
					'orderId'         => '61265b267c20561265b267c207',
					'amount'          => '60000',
					'finalAmount'     => '60000',
					'transactionDate' => '2021-08-25 18:00:55.0',
				]),
				new PaymentModel([
					'result'          => '3',
					'responseMessage' => 'DECLINED',
					'orderId'         => '612655d552d9b612655d552da1',
					'amount'          => '0',
					'finalAmount'     => '60000',
					'transactionDate' => '2021-08-25 17:38:14.0',
				]),
				new PaymentModel([
					'result'          => '1',
					'responseMessage' => 'APPROVED',
					'orderId'         => '612622cf70afe612622cf70b07',
					'amount'          => '60000',
					'finalAmount'     => '60000',
					'transactionDate' => '2021-08-25 14:00:33.0',
				]),
				new PaymentModel([
					'result'          => '1',
					'responseMessage' => 'APPROVED',
					'orderId'         => '61240d2ba24df61240d2ba24e2',
					'amount'          => '60000',
					'finalAmount'     => '60000',
					'transactionDate' => '2021-08-24 00:03:40.0',
				]),
			],
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_payment_search_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('PaymentSearchResponseApiError.txt');

		$response = new PaymentSearchResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new PaymentSearchResponseModel([
			'result'          => 0,
			'errorMessage'    => 'Bitiş tarihi başlangıç tarihinden küçük olamaz',
			'errorCode'       => 3078,
			'payments'        => NULL,
			'totalPayments'   => NULL,
			'responseMessage' => 'Bitiş tarihi başlangıç tarihinden küçük olamaz',
		]);

		$this->assertEquals($expected, $data);
	}
}
