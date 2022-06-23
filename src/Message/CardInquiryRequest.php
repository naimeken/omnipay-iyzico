<?php
/**
 * @author Philip Wright- Christie <pwrightchristie.sfp@gmail.com>
 * Date: 04/08/15
 */

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\CardInquiryRequestModel;
use Omnipay\Iyzico\Models\CreateCardRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class CardInquiryRequest extends RemoteAbstractRequest
{
	protected $endpoint = "https://api.ipara.com/bankcard/inquiry";

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
			"request_params" => new CardInquiryRequestModel([
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
	 * @param CardInquiryRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(CardInquiryRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->userId .
			$request_model->cardId .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): CardInquiryResponse
	{
		return $this->response = new CardInquiryResponse($this, $data);
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
