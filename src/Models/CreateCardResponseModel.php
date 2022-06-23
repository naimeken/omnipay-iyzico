<?php

namespace Omnipay\Iyzico\Models;

class CreateCardResponseModel extends CardModel
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
     * Hata Mesajı
     *
     * @var
     */
    public $errorMessage;

    /**
     * Müşteri Hata Mesajı
     *
     * @var
     */
    public $responseMessage;

    /**
     * Hata Kodu
     *
     * @var
     */
    public $errorCode;
}
