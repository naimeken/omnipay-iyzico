<?php

namespace Omnipay\Iyzico\Tests\Feature;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Message\ListLinkRequest;
use Omnipay\Iyzico\Message\ListLinkResponse;
use Omnipay\Iyzico\Models\LinkPaymentRecordModel;
use Omnipay\Iyzico\Models\ListLinkRequestModel;
use Omnipay\Iyzico\Models\ListLinkResponseModel;
use Omnipay\Iyzico\Models\CardModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Tests\TestCase;

class ListLinkTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function test_list_link_request()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ListLinkRequest.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new ListLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$data = $request->getData();

		$expected = [
			'request_params' => new ListLinkRequestModel([
				'clientIp'  => '127.0.0.1',
				'email'     => NULL,
				'gsm'       => NULL,
				'linkState' => NULL,
				'startDate' => NULL,
				'endDate'   => NULL,
				'pageSize'  => 10,
				'pageIndex' => 1,
			]),

			'headers' => new RequestHeadersModel([
				'transactionDate' => '2021-08-27 16:17:02',
				'version'         => '1.0',
				'token'           => 'ZZZZZ3333333333:Jm8/SVMepcRN3GuQI+oN3akb8tc=',
			]),
		];

		self::assertEquals($expected, $data);
	}

	public function test_list_link_request_validation_error()
	{
		$options = file_get_contents(__DIR__ . "/../Mock/ListLinkRequest-ValidationError.json");

		$options = json_decode($options, true, 512, JSON_THROW_ON_ERROR);

		$request = new ListLinkRequest($this->getHttpClient(), $this->getHttpRequest());

		$request->initialize($options);

		$this->expectException(InvalidRequestException::class);

		$request->getData();
	}

	public function test_list_link_response()
	{
		$httpResponse = $this->getMockHttpResponse('ListLinkResponseSuccess.txt');

		$response = new ListLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertTrue($response->isSuccessful());

		$expected = new ListLinkResponseModel([
			'result'                => 1,
			'responseMessage'       => 'Ödeme Linki listeme işlemi sonuçları başarıyla gönderildi.',
			'linkPaymentRecordList' => [
				new LinkPaymentRecordModel([
					'linkId'       => '00246NEAwI1AbOShsfcXcHbFQ==',
					'creationDate' => '2021-08-26 16:52:08',
					'linkState'    => '2',
					'name'         => 'Müşteri Ad',
					'surname'      => 'Müşteri Soyad',
					'email'        => 'mail@example.com',
					'gsm'          => '5881231212',
					'amount'       => '1000',
				]),
				new LinkPaymentRecordModel([
					'linkId'       => '002pJTRYOfAigAu1gdgFz6SYg==',
					'creationDate' => '2021-08-26 16:52:51',
					'linkState'    => '2',
					'name'         => 'Müşteri Ad',
					'surname'      => 'Müşteri Soyad',
					'email'        => 'mail@example.com',
					'gsm'          => '5881231212',
					'amount'       => '1000',
				]),
				new LinkPaymentRecordModel([
					'linkId'       => '002avY0O3/X0yDEoMQIivwg1g==',
					'creationDate' => '2021-08-26 17:04:44',
					'linkState'    => '2',
					'name'         => 'Müşteri Ad',
					'surname'      => 'Müşteri Soyad',
					'email'        => 'mail@example.com',
					'gsm'          => '5881231212',
					'amount'       => '1000',
				]),
				new LinkPaymentRecordModel([
					'linkId'        => '002jNRTN5v88RrB9zMgrB9uMw==',
					'creationDate'  => '2021-08-26 17:12:25',
					'linkState'     => '2',
					'name'          => 'Müşteri Ad',
					'surname'       => 'Müşteri Soyad',
					'tcCertificate' => '11111111111',
					'email'         => 'mail@example.com',
					'gsm'           => '5881231212',
					'amount'        => '100',
				]),
				new LinkPaymentRecordModel([
					'linkId'        => '002LkRJeAeBqsCKJc2cEgCDnA==',
					'creationDate'  => '2021-08-26 19:18:35',
					'linkState'     => '2',
					'name'          => 'Müşteri Ad',
					'surname'       => 'Müşteri Soyad',
					'tcCertificate' => '11111111111',
					'email'         => 'mail@example.com',
					'gsm'           => '5881231212',
					'amount'        => '100',
				]),
				new LinkPaymentRecordModel([
					'linkId'        => '002TmXJOFoYplcvIUTp8MZ38g==',
					'creationDate'  => '2021-08-26 19:18:39',
					'linkState'     => '2',
					'name'          => 'Müşteri Ad',
					'surname'       => 'Müşteri Soyad',
					'tcCertificate' => '11111111111',
					'email'         => 'mail@example.com',
					'gsm'           => '5881231212',
					'amount'        => '100',
				]),
				new LinkPaymentRecordModel([
					'linkId'        => '002NSAGa/+Sk8QFRFPshZZK7g==',
					'creationDate'  => '2021-08-28 15:32:31',
					'linkState'     => '2',
					'name'          => 'Müşteri Ad',
					'surname'       => 'Müşteri Soyad',
					'tcCertificate' => '11111111111',
					'email'         => 'mail@example.com',
					'gsm'           => '5881231212',
					'amount'        => '100',
				]),
				new LinkPaymentRecordModel([
					'linkId'        => '002c/oQdJhkx4rgzWi2n87nVg==',
					'creationDate'  => '2021-08-28 15:33:15',
					'linkState'     => '2',
					'name'          => 'Müşteri Ad',
					'surname'       => 'Müşteri Soyad',
					'tcCertificate' => '11111111111',
					'email'         => 'mail@example.com',
					'gsm'           => '5881231212',
					'amount'        => '100',
				]),
			],
			'pageIndex'             => '1',
			'pageSize'              => '10',
			'pageCount'             => '1',
		]);

		$this->assertEquals($expected, $data);
	}

	public function test_list_link_response_api_error()
	{
		$httpResponse = $this->getMockHttpResponse('ListLinkResponseApiError.txt');

		$response = new ListLinkResponse($this->getMockRequest(), $httpResponse);

		$data = $response->getData();

		$this->assertFalse($response->isSuccessful());

		$expected = new ListLinkResponseModel([
			'result'          => 0,
			'responseMessage' => 'İşleminiz gerçekleştirilirken beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
			'errorCode'       => 882,
			'errorMessage'    => 'Göndermiş olduğunuz token doğru değil.',
		]);

		$this->assertEquals($expected, $data);
	}
}
