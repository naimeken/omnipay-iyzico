<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\CreateCardRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class CreateCardRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/bankcard/create';

	protected $transactionDateTime;

	/**
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 * @throws \Omnipay\Common\Exception\InvalidCreditCardException
	 */
	public function getData()
	{
		$this->validateAll();

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new CreateCardRequestModel([
				"userId"          => $this->getUserReference(),
				"cardOwnerName"   => $this->getCard()->getName(),
				"cardNumber"      => $this->getCard()->getNumber(),
				"cardAlias"       => $this->getCardAlias(),
				"cardExpireMonth" => $this->getCard()->getExpiryMonth(),
				"cardExpireYear"  => $this->getCard()->getExpiryYear(),
				"clientIp"        => $this->getClientIp(),
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
	 * @throws \Omnipay\Common\Exception\InvalidCreditCardException
	 */
	protected function validateAll(): void
	{
		$this->validate("userReference", "cardAlias", "clientIp");

		$this->getCard()->validate();
	}

	/**
	 * @param CreateCardRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(CreateCardRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->userId .
			$request_model->cardOwnerName .
			$request_model->cardNumber .
			$request_model->cardExpireMonth .
			$request_model->cardExpireYear .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): CreateCardResponse
	{
		return $this->response = new CreateCardResponse($this, $data);
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
