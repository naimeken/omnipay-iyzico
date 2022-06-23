<?php

namespace Omnipay\Iyzico\Models;

class ResponseModel extends BaseModel
{
    /**
     * Sipariş toplam tutar bilgisi.
     *
     * @var string
     */
    public $amount;

    /**
     * Mağazanın istek bilgisinde iletmiş olduğu echo verisi.
     *
     * @var string
     */
    public $echo;

    /**
     * Hata Kodu
     *
     * @var string
     */
    public $errorCode;

    /**
     * Hata Mesajı
     *
     * @var string
     */
    public $errorMessage;

    /**
     * “orderId + result + amount + mode + errorCode + errorMessage + transactionDate + publicKey + privateKey” alanlarını birbirlerine, verilen sıra ile ekleyerek, SHA1 kriptografik hash fonksiyonun base64 methodu ile encode edilmesi sonucunda bu değer oluşur.
     * Not 1: İşlem sonucunda sizlere gönderilen hash bilgisini tarafınıza gelen parametreler ile tekrar hesaplayıp bu alandaki bilgi ile karşılaştırılması gerekmektedir. Eğer aynı hash değeri oluşmuyor ise işlemi reddetmelisiniz. Aksi durumda cevap bilgisi iletiminde üçüncü kişilerin araya girerek sahtekarlık yapabilme olasılığı ortaya çıkacaktır.
     * Not 2: Hash bilgisi hesaplamasında null olan veriler, String “” olarak hesaplanmıştır.
     * Not 3: İstek bilgileri içerisinde mağazanın tanımamasından kaynaklı olarak mağaza bilgileri yoksa cevap bilgisinde hash ve transactionDate alanları gönderilmeyecektir.
     *
     * @var string
     */
    public $hash;

    /**
     * İstek modu.
     * “P” - Gerçek Ödeme
     * “T” – Test Ödemesi
     *
     * @var string
     */
    public $mode;

    /**
     * Mağaza sipariş Id
     *
     * @var string
     */
    public $orderId;

    /**
     * Mağaza açık anahtar bilgisi.
     *
     * @var string
     */
    public $publicKey;

    /**
     * İşlem sonucu
     * 1 - İşlem Başarılı
     * 0 - İşlem Başarısız
     *
     * @var string
     */
    public $result;

    /**
     * Hash hesaplamasında kullanılacak zaman bilgisi. “yyyy-MM-dd HH:mm:ss“ formatındadır.
     *
     * @var string
     */
    public $transactionDate;

    public $commissionRate;

    public $threeDSecureCode;
}
