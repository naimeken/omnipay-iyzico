<?php

namespace Omnipay\Iyzico\Message;

use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\CreateLinkRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class CreateLinkRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/corporate/merchant/linkpayment/create';

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
			"request_params" => new CreateLinkRequestModel([
				"clientIp"       => $this->getClientIp(),
				"name"           => $this->get_card("getFirstName"),
				"surname"        => $this->get_card("getLastName"),
				"nationalId"     => $this->getNationalId(),
				"taxNumber"      => $this->getTaxNumber(),
				"email"          => $this->get_card("getEmail"),
				"gsm"            => $this->get_card("getPhone"),
				"amount"         => $this->getAmountInteger(),
				"threeD"         => $this->getSecure() ?? "true",
				"expireDate"     => $this->getExpireDate(),
				// TODO: API returns 3218 error when this field is present. Waiting for email reply.
				//"installmentList" => is_null($this->getInstallment()) ?: array_map("trim", explode(",", $this->getInstallment())),
				"sendEmail"      => $this->getSendEmail() ?? "true",
				"mode"           => $this->getTestMode() ? "T" : "P",
				"commissionType" => $this->getCommissionType(),
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
		$this->validate("clientIp", "amount", "expireDate");

		if (is_null($this->getNationalId()) && is_null($this->getTaxNumber())) {

			throw new InvalidRequestException("Either one of nationalId or taxNumber parameter is required.");

		}

		$cardFields = ["firstName", "lastName", "email", "phone"];

		foreach ($cardFields as $cardField) {

			$key = "get" . ucfirst($cardField);

			if (is_null($this->getCard()->$key())) {

				throw new InvalidRequestException("$cardField parameter of card must be filled.");

			}

		}
	}

	/**
	 * @param CreateLinkRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(CreateLinkRequestModel $request_model): string
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

	protected function createResponse($data): CreateLinkResponse
	{
		return $this->response = new CreateLinkResponse($this, $data);
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
