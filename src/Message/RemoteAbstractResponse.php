<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException;
use Omnipay\Iyzico\Helpers\Helper;
use Psr\Http\Message\ResponseInterface;

/**
 * Iyzico Abstract Response
 */
abstract class RemoteAbstractResponse extends AbstractResponse
{
	protected $response;

	protected $request;

	/**
	 * @throws OmnipayIyzicoHashValidationException
	 */
	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->request = $request;

		$this->response = $data;

		if ($data instanceof ResponseInterface) {

			$body = (string)$data->getBody();

			try {

				$this->response = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

			} catch (\JsonException $e) {

				$this->response = (array)simplexml_load_string($body);

			}

			if (!$this->validateHash()) {

				throw new OmnipayIyzicoHashValidationException(
					"Hash validation after request failed ! Might be a security issue."
				);

			}

		}
	}

	private function validateHash(): bool
	{
		$hash_string = ($this->response["orderId"] ?? "") .
			($this->response["result"] ?? "") .
			($this->response["amount"] ?? "") .
			($this->response["mode"] ?? "") .
			($this->response["errorCode"] ?? "") .
			($this->response["errorMessage"] ?? "") .
			($this->response["transactionDate"] ?? "") .
			$this->request->getParameters()["publicKey"] .
			$this->request->getParameters()["privateKey"];

		return $this->response["hash"] === Helper::hash(null, $hash_string);
	}
}
