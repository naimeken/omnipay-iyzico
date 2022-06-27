<?php

namespace Omnipay\Iyzico\Models;

class InstallmentDetailModel extends BaseModel
{
    /**
     * Kartın ilk 6 hanesidir.
     *
     * @var string
     */
    public string $binNumber;

    /**
     * Toplam tutar.
     *
     * @var float
     */
    public float $price;

    /**
     * Eğer ödeme yapılan kart yerel bir kart ise, kartın ait olduğu tipi. Geçerli değerler: CREDIT_CARD, DEBIT_CARD, PREPAID_CARD
     *
     * @var string
     */
    public string $cardType;

    /**
     * Eğer ödeme yapılan kart yerel bir kart ise, kartın ait olduğu kuruluş. Geçerli değerler: TROY, VISA, MASTER_CARD, AMERICAN_EXPRESS
     *
     * @var string
     */
    public string $cardAssociation;

    /**
     * Eğer ödeme yapılan kart yerel bir kart ise, kartın ait olduğu aile. Geçerli değerler: Bonus, Axess, World, Maximum, Paraf, CardFinans, Advantage
     *
     * @var string
     */
    public string $cardFamilyName;

    /**
     * İşlemin 3ds yapılmasına gerek olup olmadığını gösterir. 1 veya 0 değerlerini alır. 1 ise işlem 3ds ile yapılmalıdır.
     *
     * @var bool
     */
    public bool $force3ds;

    /**
     * Eğer ödeme yapılan kart yerel bir kart ise, kartın ait olduğu banka kodu.
     *
     * @var int
     */
    public int $bankCode;

    /**
     * Eğer ödeme yapılan kart yerel bir kart ise, kartın ait olduğu banka adı.
     *
     * @var string
     */
    public string $bankName;

    public bool $forceCvc;

    public bool $commercial;

    /**
     * @var InstallmentPriceModel[]
     */
    public $installmentPrices;
}
