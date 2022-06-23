<?php

namespace Omnipay\Iyzico\Models;

class LoginResponseModel extends BaseModel
{
    /**
     * İşlem sonucu
     * 1 - İşlem Başarılı
     * 0 - İşlem Başarısız
     *
     * @var
     */
    public $result;

    /**
     * @var
     */
    public $corporateMemberId;

    /**
     * @var
     */
    public $companyName;

    /**
     * 1|0
     *
     * @var
     */
    public $showVendorPages;

    /**
     * 1|0
     *
     * @var
     */
    public $showOosPages;

    /*
     * 1|0
     * *
     * @var
     */
    public $showLinkPaymentPages;

    /**
     * @var
     */
    public $sessionToken;

    /**
     * @var
     */
    public $oosLink;

    /**
     * 1|0
     *
     * @var
     */
    public $showMarketPlacePages;

    /**
     * @var
     */
    public $responseMessage;

    /**
     * @var
     */
    public $errorCode;

    /**
     * @var
     */
    public $errorMessage;
}
