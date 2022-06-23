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
class PurchaseRequestModel extends BaseModel
{
    public function __construct(?array $abstract)
    {
        parent::__construct($abstract);
    }

    /**
     * T Test
     * P Production
     *
     * @required
     * @var string
     */
    public $mode = "T";

    /**
     * Mağazanın ilgili sipariş ile ilişkilendirdiği her bir istek için benzersiz olan tekil sipariş kodu.
     * Maksimum Uzunluk: 100 karakter.
     *
     * @required
     * @var string
     */
    public $orderId = "";

    /**
     * Kart üzerindeki ad.
     * Minimum Uzunluk: 4 - Maksimum Uzunluk: 100 karakter.
     *
     * @var
     */
    public $cardOwnerName;

    /**
     * Kart numarası.
     * Minimum Uzunluk: 12 - Maksimum Uzunluk: 19 karakter.
     *
     * @var
     */
    public $cardNumber;

    /**
     * Kart son kullanma tarihi ay parametresi Uzunluk: 2 karakter.
     * Örnek; 05,11, vb.
     *
     * @var
     */
    public $cardExpireMonth;

    /**
     * Kart son kullanma tarihi yıl parametresi.
     * "Uzunluk: 2 karakter.
     * Örnek; 14,19, vb.
     *
     * @var
     */
    public $cardExpireYear;

    /**
     * Kartın arkasındaki güvenlik kodu: Uzunluk: MasterCard ve Visa kartları için 3 karakter, Amex kartlar için 3 veya 4 karakter.
     *
     * @var
     */
    public $cardCvc;

    /**
     * Mağaza kullanıcısını referans eden bilgi.
     * Maksimum uzunluk 255 karakter.
     * Cüzdan servisleri ile daha önceden kaydedilmiş olan kayıtlı kart ile tek tıkla ödeme işlemi gerçekleştirilmek istendiğinde gönderilmelidir.
     *
     * @var
     */
    public $userId;

    /**
     * Mağaza kullanıcısının kartını referans eden kart kaydetme işlemi sonucunda oluşan id bilgisi.
     * Cüzdan servisleri ile daha önceden kaydedilmiş olan kayıtlı kart ile tek tıkla ödeme işlemi gerçekleştirilmek istendiğinde gönderilmelidir.
     *
     * @var
     */
    public $cardId;

    /**
     * Taksit Sayısı.
     * Minimum Uzunluk: 1 - Maksimum Uzunluk: 2 karakter.
     * Desteklenen taksit sayıları: 1,2,3,4,5,6,7,8,9,10,11,12
     *
     * @var
     */
    public $installment;

    /**
     * Karttan çekilecek olan toplam sipariş tutarı.
     * Sipariş tutarı kuruş ayracı olmadan gönderilmelidir.
     * Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilmelidir.
     *
     * @var
     */
    public $amount;

    /**
     * Mağazaya istek sonucunda geri gönderilecek bilgi alanıdır.
     * Maksimum Uzunluk: 255.
     *
     * @var
     */
    public $echo;

    /**
     * iPara tarafından sağlanan altyapı sağlayıcı id bilgisi.
     * Mağaza kendi yazılımını kullanıyor ise bu alan gönderilmemelidir.
     *
     * @var
     */
    public $vendorId;

    /**
     * Müşteri Bilgileri.
     * Aşağıdaki tabloda iç parametreleri anlatılmıştır.
     *
     * @var PurchaserModel
     */
    public $purchaser;

    /**
     * Ürün Bilgileri. Aşağıdaki tabloda iç parametreleri anlatılmıştır.
     *
     * @required
     * @var ProductModel[]
     */
    public $products;
}
