<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Models\ChargeRequestModel;
use Omnipay\Iyzico\Models\PurchaseRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class AuthorizeRequest extends PurchaseRequest
{
    protected $endpoint = "https://api.ipara.com/rest/payment/preauth";

    /**
     * @return array{request_params: ChargeRequestModel, headers: RequestHeadersModel}
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = parent::getData();

        $data["request_params"] = new PurchaseRequestModel($data["request_params"]);

        return $data;
    }

    /**
     * @throws \Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException
     */
    protected function createResponse($data): ChargeResponse
    {
        return $this->response = new ChargeResponse($this, $data);
    }

    /**
     * @param array{request_params: ChargeRequestModel, headers: RequestHeadersModel} $data
     *
     * @return ChargeResponse
     * @throws \Omnipay\Iyzico\Exceptions\OmnipayIyzicoHashValidationException
     */
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
