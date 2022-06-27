<?php

namespace Omnipay\Iyzico\Models;

use Omnipay\Iyzico\Traits\HasResponse;

class BinLookupResponseModel extends BaseModel
{
    use HasResponse;

    /**
     * @var InstallmentDetailModel[]
     */
    public array $installmentDetails;
}
