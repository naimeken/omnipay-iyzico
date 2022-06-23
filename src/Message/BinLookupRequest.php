<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\BinLookupRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class BinLookupRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/rest/payment/bin/lookup/v2';

	protected $transactionDateTime;

	/**
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 * @throws InvalidCreditCardException
	 */
	public function getData()
	{
		$this->validateAll();

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new BinLookupRequestModel([
				"binNumber" => $this->getCard()->getNumber(),
				"amount"    => $this->getAmountInteger(),
				"threeD"    => $this->getSecure(),
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
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 * @throws InvalidCreditCardException
	 */
	protected function validateAll(): void
	{
		$this->validate("amount", "secure");

		if (!is_null($this->getCard()->getNumber()) && !preg_match('/^\d{8,19}$/', $this->getCard()->getNumber())) {
			throw new InvalidCreditCardException('Card number should have at least 6 to maximum of 19 digits');
		}
	}

	/**
	 * @param BinLookupRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(BinLookupRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->binNumber .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	/**
	 * @throws \JsonException
	 */
	protected function createResponse($data): BinLookupResponse
	{
		return $this->response = new BinLookupResponse($this, $data);
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
