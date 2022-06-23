<?php

namespace Omnipay\Iyzico\Message;

use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Constants\LinkState;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\ListLinkRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class ListLinkRequest extends RemoteAbstractRequest
{
	protected $endpoint = 'https://api.ipara.com/corporate/merchant/linkpayment/list';

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
			"request_params" => new ListLinkRequestModel([
				"clientIp"  => $this->getClientIp(),
				"email"     => $this->get_card("getEmail"),
				"gsm"       => $this->get_card("getPhone"),
				"linkState" => $this->getLinkState(),
				"startDate" => $this->getStartDate(),
				"endDate"   => $this->getEndDate(),
				"pageSize"  => $this->getPageSize(),
				"pageIndex" => $this->getPageIndex(),
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
		$this->validate("clientIp");

		if (!is_null($this->getLinkState())) {

			$states = (new LinkState)->list();

			if (!in_array($this->getLinkState(), $states, true)) {

				throw new InvalidRequestException(
					"linkState parameter is not valid. Possible options are " . implode(", ", $states) . "."
				);

			}

		}

		$pageSize = $this->getPageSize();

		if ($pageSize < 5 || $pageSize > 15) {

			throw new InvalidRequestException(
				"pageSize parameter must be >= 5 and <= 15"
			);

		}
	}

	/**
	 * @param ListLinkRequestModel $request_model
	 *
	 * @return string
	 */
	protected function token(ListLinkRequestModel $request_model): string
	{
		$hash_string =
			$this->getPrivateKey() .
			$request_model->clientIp .
			($this->getTransactionDate() ?? $this->transactionDateTime);

		return Helper::hash($this->getPublicKey(), $hash_string);
	}

	protected function createResponse($data): ListLinkResponse
	{
		return $this->response = new ListLinkResponse($this, $data);
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
