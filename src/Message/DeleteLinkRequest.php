<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\DeleteLinkRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class DeleteLinkRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/corporate/merchant/linkpayment/delete';

	protected $transactionDateTime;

	/**
	 * @throws InvalidRequestException
	 */
	public function getData()
	{
		$this->validate("clientIp", "linkId");

		date_default_timezone_set('Europe/Istanbul');

		$this->transactionDateTime = date("Y-m-d H:i:s");

		$data = [
			"request_params" => new DeleteLinkRequestModel([
				"clientIp" => $this->getClientIp(),
				"linkId"   => $this->getLinkId(),
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
	 * @param DeleteLinkRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(DeleteLinkRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): DeleteLinkResponse
	{
		return $this->response = new DeleteLinkResponse($this, $data);
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
