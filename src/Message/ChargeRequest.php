<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Iyzico\Models\ChargeRequestModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class ChargeRequest extends PurchaseRequest
{
    protected $endpoint = "https://api.ipara.com/rest/payment/auth";

    /**
     * @return array{request_params: ChargeRequestModel, headers: RequestHeadersModel}
     * @throws InvalidCreditCardException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $data = parent::getData();

        $data["request_params"] = new ChargeRequestModel($data["request_params"]);

        return $data;
    }

    protected function validateAll()
    {
        if ($this->getCardReference() && $this->getUserReference()) {

            $this->validate("cardReference", "userReference");

        } else {

            $this->getCard()->validate();

        }

        $this->validate(
            "amount",
            "transactionId",
            "installment",
            "privateKey",
            "publicKey",
            "items",
        );
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
                'Content-Type' => 'application/xml',
                'Accept'       => 'application/xml',
            ]),
            $data["request_params"]->asXml("auth")
        );

        return $this->createResponse($httpResponse);
    }
}
