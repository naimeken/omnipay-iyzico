<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\CaptureResponseModel;

class CaptureResponse extends RemoteAbstractResponse
{
	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new CaptureResponseModel((array)$this->response);
	}

	public function isSuccessful(): bool
	{
		return $this->response->result === 1;
	}

	public function getMessage(): string
	{
		return (string)$this->response->errorMessage;
	}

	public function getCode(): string
	{
		return (string)$this->response->errorCode;
	}

	public function getData(): CaptureResponseModel
	{
		return $this->response;
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
