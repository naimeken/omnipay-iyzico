<?php

namespace Omnipay\Iyzico\Message;

use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\CaptureRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class CaptureRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/rest/payment/postauth';

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
			"request_params" => new CaptureRequestModel([
				"name"     => $this->get_card("getFirstName"),
				"surname"  => $this->get_card("getLastName"),
				"email"    => $this->get_card("getEmail"),
				"mode"     => $this->getTestMode() ? "T" : "P",
				"orderId"  => $this->getTransactionId(),
				"amount"   => $this->getAmountInteger(),
				"clientIp" => $this->getClientIp(),
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
	 * @throws Exception
	 */
	protected function validateAll(): void
	{
		$this->validate("transactionId", "amount");

		$cardFields = ["firstName", "lastName", "email"];

		foreach ($cardFields as $cardField) {

			$key = "get" . ucfirst($cardField);

			if (is_null($this->getCard()->$key())) {

				throw new InvalidRequestException("$cardField parameter of card must be filled.");

			}

		}
	}

	/**
	 * @param CaptureRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(CaptureRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->name .
			$request_model->surname .
			$request_model->email .
			$request_model->amount .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): CaptureResponse
	{
		return $this->response = new CaptureResponse($this, $data);
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
