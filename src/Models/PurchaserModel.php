<?php

namespace Omnipay\Iyzico\Models;

class PurchaserModel extends BaseModel
{
    /**
     * Müşteri isim bilgisi.
     * Minimum Uzunluk: 3 - Maksimum Uzunluk: 50. Zorunlu
     *
     * @required
     * @var string
     */
    public $name = "";

    /**
     * Müşteri soyisim bilgisi.
     * Minimum Uzunluk: 3 - Maksimum Uzunluk: 50.
     *
     * @required
     * @var string
     */
    public $surname = "";

    /**
     * Müşteri e-posta bilgisi.
     * E-posta adresi geçerli bir e-posta adresi olmalıdır.
     * Minimum Uzunluk: 3 - Maksimum Uzunluk: 100.
     *
     * @required
     * @var string
     */
    public $email = "";

    /**
     * Müşteri istemci IP adresi
     *
     * @required
     * @var string
     */
    public $clientIp;

    /**
     * Müşteri doğum tarihi bilgisi. “yyyy-MM-dd” formatında olmalıdır.
     *
     * @var string
     */
    public $birthDate;

    /**
     * Müşteri cep telefonu bilgisi.
     *
     * @var string
     */
    public $gsmNumber;

    /**
     * Müşteri T.C. Kimlik Numarası bilgisi. 11 haneli olmalıdır.
     *
     * @var string
     */
    public $tcCertificate;

    /**
     * Fatura adresi bilgileri.
     *
     * @var InvoiceAddressModel
     */
    public $invoiceAddress;

    /**
     * Kargo adresi bilgileri.
     *
     * @var AddressModel
     */
    public $shippingAddress;

}
