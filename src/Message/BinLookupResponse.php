<?php

namespace Omnipay\Ipara\Message;

use JsonException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Ipara\Models\BinLookupResponseModel;
use Psr\Http\Message\ResponseInterface;

class BinLookupResponse extends AbstractResponse
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

				$this->response = new BinLookupResponseModel($data);

			} catch (JsonException $e) {

				$this->response = new BinLookupResponseModel([
					"result"       => 0,
					"errorMessage" => $body,
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
		return (string)$this->response->errorMessage;
	}

	public function getData(): BinLookupResponseModel
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
