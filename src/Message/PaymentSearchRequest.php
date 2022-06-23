<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\PaymentSearchRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class PaymentSearchRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/rest/payment/search';

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
			"request_params" => new PaymentSearchRequestModel([
				"mode"      => $this->getTestMode() ? "T" : "P",
				"startDate" => $this->getStartDate(),
				"endDate"   => $this->getEndDate(),
				"echo"      => $this->getEcho(),
			]),

			"headers" => null,
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
		$this->validate("testMode", "startDate", "endDate");
	}

	/**
	 * @param PaymentSearchRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(PaymentSearchRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->mode .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): PaymentSearchResponse
	{
		return $this->response = new PaymentSearchResponse($this, $data);
	}

	public function sendData($data)
	{
		$httpResponse = $this->httpClient->request(
			'POST',
			$this->getEndpoint(),
			array_merge((array)$data["headers"], [
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			]),
			json_encode($data["request_params"])
		);

		return $this->createResponse($httpResponse);
	}
}
