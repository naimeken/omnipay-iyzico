<?php

namespace Omnipay\Iyzico\Models;

/**
 * En az bir adet ürün (product) bilgisi gönderimi zorunludur.
 */
class ProductModel extends BaseModel
{
    public $productCode;

    public $productName;

    public $quantity;

    public $price;
}
