<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\RequestHeadersModel;

class CheckoutFormInquiryRequest extends RemoteAbstractRequest
{
    protected $endpoint = '/payment/iyzipos/checkoutform/auth/ecom/detail';

    /**
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @throws InvalidCreditCardException
     */
    public function getData()
    {
        $this->validateAll();

        $request_params = [
            'locale' => $this->getLanguage(),
            'conversationId' => uniqid('', true),
            'token' => $this->getToken(),
        ];

        return [
            'request_params' => $request_params,
            'headers' => new RequestHeadersModel([
                'Authorization' => $this->token($request_params),
                'x-iyzi-rnd' => $this->getRandomString(),
                'x-iyzi-client-version' => 'tcgunel/omnipay-iyzico:v0.0.1',
            ]),
        ];
    }

    /**
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function validateAll(): void
    {
        $this->validate('token');
    }

    protected function token(array $request_model): string
    {
        $appends = $request_model;

        return 'IYZWSv2 ' . Helper::hashV2($this->getPublicKey(), $this->getPrivateKey(), $appends, $this->getRandomString(), $this->endpoint);
    }

    /**
     * @throws \JsonException
     */
    protected function createResponse($data): CheckoutFormInquiryResponse
    {
        return $this->response = new CheckoutFormInquiryResponse($this, $data);
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            array_merge($data['headers']->__toArray(), [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
            json_encode($data['request_params'])
        );

        return $this->createResponse($httpResponse);
    }
}
