<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Item;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Iyzico\Helpers\Helper;
use Omnipay\Iyzico\Models\AddressModel;
use Omnipay\Iyzico\Models\EnrolmentRequestModel;
use Omnipay\Iyzico\Models\InvoiceAddressModel;
use Omnipay\Iyzico\Models\ChargeRequestModel;
use Omnipay\Iyzico\Models\ProductModel;
use Omnipay\Iyzico\Models\PurchaserModel;
use Omnipay\Iyzico\Models\RequestHeadersModel;
use Omnipay\Iyzico\Traits\PurchaseGettersSetters;

class PurchaseRequest extends RemoteAbstractRequest
{
    use PurchaseGettersSetters;

    protected $transactionDateTime;

    /**
     * @return array{request_params: array, headers: RequestHeadersModel}
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     */
    public function getData()
    {
        $this->validateAll();

        date_default_timezone_set('Europe/Istanbul');

        $this->transactionDateTime = date("Y-m-d H:i:s");

        $data = [
            "request_params" => [
                "mode"            => $this->getTestMode() ? "T" : "P",
                "threeD"          => $this->getSecure() ?? "false",
                "orderId"         => $this->getTransactionId(),
                "cardOwnerName"   => $this->get_card("getName"),
                "cardNumber"      => $this->get_card("getNumber"),
                "cardExpireMonth" => $this->get_card("getExpiryMonth"),
                "cardExpireYear"  => $this->get_card("getExpiryYear"),
                "cardCvc"         => $this->get_card("getCvv"),
                "userId"          => $this->getUserReference() == "" ? null : $this->getUserReference(),
                "cardId"          => $this->getCardReference(),
                "installment"     => $this->getInstallment() ?? "1",
                "amount"          => (string)$this->getAmountInteger(),
                "echo"            => $this->getEcho(),
                "vendorId"        => $this->getVendorId(),
                "language"        => $this->getLanguage() ?? "tr-TR",

                "deviceUUID" => $this->getDeviceUUID(),
                "successUrl" => $this->getReturnUrl(),
                "failureUrl" => $this->getCancelUrl(),

                "transactionDate" => $this->getTransactionDate() ?? $this->transactionDateTime,
                "version"         => $this->getVersion() ?? "1.0",
                "token"           => "",


                "purchaser" => new PurchaserModel([

                    "name"          => $this->get_card("getBillingFirstName"),
                    "surname"       => $this->get_card("getBillingLastName"),
                    "email"         => $this->get_card("getEmail") ?? "required-dummy@email.com",
                    "clientIp"      => $this->getClientIp() ?? "127.0.0.1",
                    "birthDate"     => $this->get_card("getBirthday") ?? "1950-01-01",
                    "gsmNumber"     => join("", [$this->get_card("getPhoneExtension"), $this->get_card("getPhone")]),
                    "tcCertificate" => $this->getNationalId() ?? "11111111111",

                    "invoiceAddress" => new InvoiceAddressModel([

                        "name"          => $this->get_card("getBillingFirstName"),
                        "surname"       => $this->get_card("getBillingLastName"),
                        "address"       => join(" ", [$this->get_card("getBillingAddress1"), $this->get_card("getBillingAddress2")]),
                        "zipcode"       => $this->get_card("getBillingPostcode"),
                        "city"          => $this->get_card("getBillingCity"),
                        "country"       => $this->get_card("getBillingCountry"),
                        "phoneNumber"   => join("",
                            [$this->get_card("getBillingPhoneExtension"), $this->get_card("getBillingPhone")]),
                        "tcCertificate" => $this->getNationalId(),
                        "taxNumber"     => $this->getTaxNumber(),
                        "taxOffice"     => $this->getTaxOffice(),
                        "companyName"   => $this->get_card("getCompany"),

                    ]),

                    "shippingAddress" => new AddressModel([

                        "name"        => $this->get_card("getShippingFirstName"),
                        "surname"     => $this->get_card("getShippingLastName"),
                        "address"     => join(" ", [$this->get_card("getShippingAddress1"), $this->get_card("getShippingAddress2")]),
                        "zipcode"     => $this->get_card("getShippingPostcode"),
                        "city"        => $this->get_card("getShippingCity"),
                        "country"     => $this->get_card("getShippingCountry"),
                        "phoneNumber" => join("",
                            [$this->get_card("getShippingPhoneExtension"), $this->get_card("getShippingPhone")]),

                    ]),
                ]),

                "products" => array_map(function (Item $item) {
                    return new ProductModel([
                        "productCode" => hash("sha1", $item->getName() . $item->getPrice()),
                        "productName" => $item->getName(),
                        "quantity"    => $item->getQuantity(),
                        "price"       => $item->getPrice(),
                    ]);
                }, $this->getItems()->all()),
            ],
            "headers"        => null,
        ];

        $data["headers"] = new RequestHeadersModel([
            "transactionDate" => $this->getTransactionDate() ?? $this->transactionDateTime,
            "version"         => $this->getVersion(),
            "token"           => $this->token($data["request_params"]),
        ]);

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
     * @param EnrolmentRequestModel|ChargeRequestModel $request_model
     *
     * @return string
     */
    protected function token($request_model): string
    {
        $request_model = json_decode(json_encode($request_model), true);

        $hash_string =
            $this->getPrivateKey() .
            $request_model["orderId"] .
            $request_model["amount"] .
            $request_model["mode"] .
            $request_model["cardOwnerName"] .
            $request_model["cardNumber"] .
            $request_model["cardExpireMonth"] .
            $request_model["cardExpireYear"] .
            $request_model["cardCvc"] .
            $request_model["userId"] .
            $request_model["cardId"] .
            $request_model["purchaser"]["name"] .
            $request_model["purchaser"]["surname"] .
            $request_model["purchaser"]["email"] .
            ($this->getTransactionDate() ?? $this->transactionDateTime);

        return Helper::hash($this->getPublicKey(), $hash_string);
    }

    protected function createResponse($data)
    {
        // overridden by child class
    }

    public function sendData($data)
    {
        // overridden by child class
    }
}
