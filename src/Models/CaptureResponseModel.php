<?php

namespace Omnipay\Iyzico\Models;

class CaptureResponseModel extends BaseModel
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
	 * Mağaza sipariş Id
	 *
	 * @var
	 */
	public $orderId;

	/**
	 * Sipariş toplam tutar bilgisi
	 *
	 * @var
	 */
	public $amount;

	/**
	 * İstek modu.
	 * "P" - Gerçek Ödeme
	 * "T" – Test Ödemesi
	 *
	 * @var
	 */
	public $mode;

	/**
	 * Mağaza açık anahtar bilgisi.
	 *
	 * @var
	 */
	public $publicKey;

	/**
	 * Mağazanın istek bilgisinde iletmiş olduğu echo verisi.
	 *
	 * @var
	 */
	public $echo;

	/**
	 * Hata Kodu
	 *
	 * @var
	 */
	public $errorCode;

    /**
     * Hata Mesajı
     *
     * @var
     */
    public $errorMessage;

    /**
     * Hash hesaplamasında kullanılacak zaman bilgisi. “yyyy-MM-dd HH:mm:ss“ formatındadır.*
     *
     * @var
     */
    public $transactionDate;

    /**
     * "orderId + result + amount + mode + errorCode + errorMessage + transactionDate + publicKey + privateKey" alanlarını birbirlerine, verilen sıra ile ekleyerek, SHA1 kriptografik hash fonksiyonun base64 methodu ile encode edilmesi sonucunda bu değer oluşur.
     * Not 1: İşlem sonucunda sizlere gönderilen hash bilgisini tarafınıza gelen parametreler ile tekrar hesaplayıp bu alandaki bilgi ile karşılaştırılması gerekmektedir. Eğer aynı hash değeri oluşmuyor ise işlemi reddetmelisiniz. Aksi durumda cevap bilgisi iletiminde üçüncü kişilerin araya girerek sahtekarlık yapabilme olasılığı ortaya çıkacaktır.
     * Not 2: Hash bilgisi hesaplamasında null olan veriler, String “” olarak hesaplanmıştır.
     * Not 3: İstek bilgileri içerisinde mağazanın tanımamasından kaynaklı olarak mağaza bilgileri yoksa cevap bilgisinde hash ve transactionDate alanları gönderilmeyecektir.
     *
     * @var
     */
    public $hash;
}
