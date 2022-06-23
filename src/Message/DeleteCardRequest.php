<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\DeleteCardRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class DeleteCardRequest extends RemoteAbstractRequest
{
	protected $endpoint = "https://api.ipara.com/bankcard/delete";

	protected $transactionDateTime;

	/**
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	public function getData()
	{
		$this->validateAll();

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new DeleteCardRequestModel([
				"userId"   => $this->getUserReference(),
				"cardId"   => $this->getCardReference(),
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
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	protected function validateAll(): void
	{
		$this->validate("userReference");
	}

	/**
	 * @param DeleteCardRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(DeleteCardRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->userId .
			$request_model->cardId .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): DeleteCardResponse
	{
		return $this->response = new DeleteCardResponse($this, $data);
	}

	/**
	 * @throws \Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException
	 */
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
