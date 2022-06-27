<?php

namespace Omnipay\Iyzico\Models;

class InstallmentPriceModel extends BaseModel
{
    /**
     * Taksit başına düşen tutar.
     *
     * @var float
     */
    public float $installmentPrice;

    /**
     * Toplam taksitli tutar.
     *
     * @var float
     */
    public float $totalPrice;

    /**
     * Taksit sayısı.
     *
     * @var int
     */
    public int $installmentNumber;
}
