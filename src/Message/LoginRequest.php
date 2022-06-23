<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\LoginRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class LoginRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/corporate/member/login';

	protected $transactionDateTime;

	/**
	 * @throws InvalidCreditCardException
	 */
	public function getData()
	{
		$this->validateAll();

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new LoginRequestModel([
				"clientIp"        => $this->getClientIp(),
				"corporateNumber" => $this->getCorporateNumber(),
				"username"        => $this->getUsername(),
				"password"        => $this->getPassword(),
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
		$this->validate("clientIp", "corporateNumber", "username", "password");
	}

	/**
	 * @param LoginRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(LoginRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->corporateNumber .
			$request_model->username .
			$request_model->password .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): LoginResponse
	{
		return $this->response = new LoginResponse($this, $data);
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
