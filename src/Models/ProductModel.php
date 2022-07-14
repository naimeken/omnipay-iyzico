<?php

namespace Omnipay\Iyzico\Models;

/**
 * En az bir adet ürün (product) bilgisi gönderimi zorunludur.
 */
class ProductModel extends BaseModel
{
    public string $id;

    public float $price;

    public string $name;

    public string $category1;

    public string $category2;

    public string $itemType;
}
