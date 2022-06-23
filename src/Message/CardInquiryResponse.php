<?php
/**
 * @author Philip Wright- Christie <pwrightchristie.sfp@gmail.com>
 * Date: 04/08/15
 */

namespace Omnipay\Iyzico\Message;

use JsonException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Models\CardInquiryResponseModel;
use Psr\Http\Message\ResponseInterface;

class CardInquiryResponse extends AbstractResponse
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

				$this->response = new CardInquiryResponseModel($data);

			} catch (JsonException $e) {

				$this->response = new CardInquiryResponseModel([
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
		return $this->response->responseMessage;
	}

	public function getData(): CardInquiryResponseModel
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
