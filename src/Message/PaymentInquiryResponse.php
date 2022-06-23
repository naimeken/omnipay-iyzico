<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\PaymentInquiryResponseModel;

class PaymentInquiryResponse extends RemoteAbstractResponse
{
	/**
	 * @throws \Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException
	 * @throws \JsonException
	 */
	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->response = new PaymentInquiryResponseModel(json_decode(json_encode((array)$this->response, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR));
	}

	public function isSuccessful(): bool
	{
		return $this->response->result === "1";
	}

	public function getMessage(): ?string
	{
		return $this->response->responseMessage ?? $this->response->errorMessage;
	}

	public function getData(): PaymentInquiryResponseModel
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
