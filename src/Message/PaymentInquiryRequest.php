<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\PaymentInquiryRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class PaymentInquiryRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/rest/payment/inquiry';

	protected $transactionDateTime;

	/**
	 * @throws InvalidRequestException
	 */
	public function getData()
	{
		$this->validateAll();

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new PaymentInquiryRequestModel([
				"mode"    => $this->getTestMode() ? "T" : "P",
				"orderId" => $this->getTransactionId(),
				"echo"    => $this->getEcho(),
			]),
			"headers"        => null,
		];

		$data["headers"] = new RequestHeadersModel([
			"transactionDate" => $this->getTransactionDate() ?? $this->transactionDateTime,
			"version"         => $this->getVersion(),
			"token"           => $this->token($data["request_params"]),
		]);

		return $data;
	}

	/**
	 * @throws InvalidRequestException
	 */
	protected function validateAll(): void
	{
		$this->validate("testMode", "transactionId");
	}

	/**
	 * @param PaymentInquiryRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(PaymentInquiryRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->orderId .
			$request_model->mode .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	/**
	 * @throws OmnipayIyzicoHashValidationException
	 */
	protected function createResponse($data): PaymentInquiryResponse
	{
		return $this->response = new PaymentInquiryResponse($this, $data);
	}

	/**
	 * @param array{request_params: PaymentInquiryRequestModel, headers: RequestHeadersModel} $data
	 *
	 * @return PaymentInquiryResponse
	 * @throws OmnipayIyzicoHashValidationException
	 */
	public function sendData($data): PaymentInquiryResponse
	{
		$httpResponse = $this->httpClient->request(
			'POST',
			$this->getEndpoint(),
			array_merge((array)$data["headers"], [
				'Content-Type' => 'application/xml',
				'Accept'       => 'application/xml',
			]),
			$data["request_params"]->asXml("inquiry")
		);

		return $this->createResponse($httpResponse);
	}
}
