<?php
namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\DeleteLinkResponseModel;
use Psr\Http\Message\ResponseInterface;

class DeleteLinkResponse extends AbstractResponse
{
	protected $response;

	protected $request;

	/**
	 */
	public function __construct(RequestInterface $request, $data)
	{
		parent::__construct($request, $data);

		$this->request = $request;

		$this->response = $data;

		if ($data instanceof ResponseInterface) {

			$body = (string)$data->getBody();

			try {

				$data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

				$this->response = new DeleteLinkResponseModel($data);

			} catch (\JsonException $e) {

				$this->response = new DeleteLinkResponseModel([
					"result"          => 0,
					"responseMessage" => $body,
				]);

			}

		}
	}

	public function isSuccessful(): bool
	{
		return ($this->response->result === 1);
	}

	public function getMessage(): ?string
	{
		return $this->response->responseMessage ?? $this->response->errorMessage;
	}

	public function getData(): DeleteLinkResponseModel
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
