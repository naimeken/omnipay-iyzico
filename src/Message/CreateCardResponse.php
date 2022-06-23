<?php

namespace Omnipay\Iyzico\Message;

use JsonException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\CreateCardResponseModel;
use Psr\Http\Message\ResponseInterface;

class CreateCardResponse extends AbstractResponse
{
	protected $response;

	protected $request;

	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->request = $request;

		$this->response = $data;

		if ($data instanceof ResponseInterface) {

			$body = (string)$data->getBody();

			try {

				$data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

				$this->response = new CreateCardResponseModel($data);

			} catch (JsonException $e) {

				$this->response = new CreateCardResponseModel([
					"result"          => 0,
					"responseMessage" => $body,
				]);

			}

		}
	}

	public function isSuccessful(): bool
	{
		return $this->response->result === 1;
	}

	public function getMessage(): string
	{
		return $this->response->responseMessage ?? $this->response->errorMessage;
	}

	public function getData(): CreateCardResponseModel
	{
		return $this->response;
	}

	public function getCardReference()
	{
		return $this->response->cardId;
	}

	public function getRedirectData()
	{
		return null;
	}

	public function getRedirectUrl(): string
	{
		return '';
	}
}
