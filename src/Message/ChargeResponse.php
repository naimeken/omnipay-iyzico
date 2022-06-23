<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\ResponseModel;

class ChargeResponse extends RemoteAbstractResponse
{
	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new ResponseModel((array)$this->response);
	}

	public function getData(): ResponseModel
	{
		return $this->response;
	}

	public function isSuccessful(): bool
	{
		return $this->response->result === "1";
	}

	public function getMessage(): ?string
	{
		return $this->response->errorMessage;
	}

	public function getTransactionId(): ?string
	{
		return $this->response->orderId;
	}

	public function getCode(): ?string
	{
		return $this->response->errorCode;
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
