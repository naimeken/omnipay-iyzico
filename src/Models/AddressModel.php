<?php

namespace Omnipay\Iyzico\Models;

class AddressModel extends BaseModel
{
    public $name;

    public $surname;

    public $address;

    public $zipcode;

    public $city;

    /**
     * Ülke bilgisi. ISO 3166-1 alpha-2 standardındaki ülke kodu. Türkiye için “TR”.
     *
     * @var string
     */
    public $country;

    public $phoneNumber;
}

