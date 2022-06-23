<?php

namespace Omnipay\Iyzico\Models;

/**
 * Parameter descriptions directly taken from official documentation.
 *
 * Kayıtsız kart ile ödeme isteğinde cardOwnerName, cardNumber, cardExpireMonth, cardExpireYear, cardCvc alanları zorunludur.
 * userId ve cardId bilgileri gönderilmemelidir ve token hesaplaması yapılırken userId ve cardId bilgileri String “” olarak
 * hesaplamaya eklenmelidir.
 *
 * Kayıtlı kart ile ödeme isteğinde userId ve cardId bilgileri zorunludur.
 * cardOwnerName, cardNumber, cardExpireMonth, cardExpireYear alanları gönderilmemelidir ve token hesaplaması yapılırken
 * String “” olarak hesaplamaya eklenmelidir.
 * cardCvc alanı kayıtlı kart ile ödeme talebinde opsiyoneldir, gönderilir ise token hesaplamasına dahil edilmelidir.
 *
 * @link https://dev.ipara.com.tr/home/PaymentServices#apiPayment
 */
class EnrolmentRequestModel extends PurchaseRequestModel
{
    public function __construct(?array $abstract)
    {
        parent::__construct($abstract);
    }

    /**
     * İşlemin başarılı olarak sonuçlanması durumunda alıcının yönlendirileceği adres.
     * Maksimum Uzunluk: 500. Önemli Not: Url bilgisi http:// veya https:// ile başlamalıdır.
     *
     * @required
     * @var string
     */
    public $successUrl = "";

    /**
     * İşlemin hatalı olarak sonuçlanması durumunda alıcının yönlendirileceği adres.
     * Maksimum Uzunluk: 500. Önemli Not 1: Url bilgisi http:// veya https:// ile başlamalıdır.
     * Önemli Not 2: Failure url bilgisi hatalı ise dönülecek adres belirlenemediğinden mağazaya dönüş gerçekleşemeyecek ve boş sayfa açılacaktır.
     * Bu durumda göndermiş olduğunuz url bilgisini kontrol etmenizi rica ederiz.
     *
     * @required
     * @var string
     */
    public $failureUrl = false;

    /**
     * İstek zamanı bilgisi. “yyyy-MM-dd HH:mm:ss“ formatındadır.
     * İşlem zaman aşımına uğramış ise istek reddedilir. Örnek: “2014-08-12 23:59:59”
     *
     * @required
     * @var string
     */
    public $transactionDate = "";

    /**
     * Entegrasyon versiyon bilgisidir. “1.0” olarak gönderilmelidir.
     *
     * @required
     * @var string
     */
    public $version = "1.0";

    /**
     * @var string
     */
    public $deviceUUID;

    /**
     * @var string
     */
    public $token = "";

    /**
     * ‘’tr-TR” veya “en-US” olarak gönderilmelidir.
     *
     * @required
     * @var string
     */
    public $language = "tr-TR";
}
