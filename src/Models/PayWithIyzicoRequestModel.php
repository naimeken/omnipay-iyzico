<?php

namespace Omnipay\Iyzico\Models;

class PayWithIyzicoRequestModel extends BaseModel
{
    public function __construct(?array $abstract)
    {
        parent::__construct($abstract);
    }

    public string $locale;
    public string $conversationId;
    public $price;
    public $paidPrice;
    public string $basketId;
    public string $paymentGroup;

    public PurchaserModel $buyer;

    public AddressModel $shippingAddress;

    public AddressModel $billingAddress;

    /**
     * @var ProductModel[]
     */
    public $basketItems;

    public string $paymentSource;

    public string $currency;

    public string $callbackUrl;
    public $enabledInstallments;
}
