<?php

namespace Omnipay\Iyzico\Message;

use JsonException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\LoginResponseModel;
use Psr\Http\Message\ResponseInterface;

class LoginResponse extends AbstractResponse
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

				$this->response = new LoginResponseModel($data);

			} catch (JsonException $e) {

				$this->response = new LoginResponseModel([
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

	public function getMessage(): ?string
	{
		return $this->response->responseMessage ?? $this->response->errorMessage ?? "";
	}

	public function getData(): LoginResponseModel
	{
		return $this->response;
	}

	public function getRedirectData()
	{
		return null;
	}

	public function getRedirectUrl()
	{
		return '';
	}
}
