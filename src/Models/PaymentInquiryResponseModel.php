<?php

namespace Omnipay\Iyzico\Models;

class PaymentInquiryResponseModel extends BaseModel
{
	/**
	 * Ödeme durumunu belirten sonuç bilgisi.
	 * 0 – Entegrasyon Hatası
	 * 1 – Ödeme başarılı
	 * 2 – Ödeme iade edilmiş
	 * 3 – Ödeme reddedilmiş
	 * 4 – Ödeme bulunamadı
	 * 6 – Parçalı iade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * 7 – İade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * 8 – İade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 * 9 – Parçalı iade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 *
	 * @var
	 */
	public $result;

	/**
	 * Ödeme durumunu belirten mesajdır
	 * APPROVED – Ödeme başarılı
	 * REFUNDED – Ödeme iade edilmiş
	 * DECLINED – Ödeme rededilmiş
	 * NOT_FOUND – Ödeme bulunamadı
	 * APPROVED_BUT_WAITING_MANUAL_PARTIAL_REFUND - Parçalı iade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * APPROVED_BUT_WAITING_MANUAL_REFUND – İade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * APPROVED_BUT_WAITING_MONEY_TRANSFER_FOR_REFUND – İade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 * APPROVED_BUT_WAITING_MONEY_TRANSFER_FOR_PARTIAL_REFUND – Parçalı iade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 *
	 * @var
	 */
	public $responseMessage;

	/**
	 * Hata Mesajı
	 *
	 * @var
	 */
	public $errorMessage;

	/**
	 * Hata Kodu
	 *
	 * @var
	 */
	public $errorCode;

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
	 * Hash hesaplamasında kullanılacak zaman bilgisi. “yyyy-MM-dd HH:mm:ss“ formatındadır.
	 *
	 * @var
	 */
	public $transactionDate;

	/**
	 * İstek modu.
	 * “P” - Gerçek Ödeme
	 * “T” – Test Ödemesi
	 *
	 * @var
	 */
	public $mode;

	/**
	 * Mağaza sipariş Id
	 *
	 * @var
	 */
	public $orderId;

	/**
	 * Ödemenin kalan miktarı.
	 * Kuruş değerinde yollanacaktır.
	 * Örneğin; 1 TL için 100, 12 TL için 1200, 1.05 TL için 105, 1.2 TL için 120 olarak gönderilecektir.
	 * Eğer ödemenin tamamı iade edilmişse “000” değeri dönecektir.
	 *
	 * @var
	 */
	public $amount;

	/**
	 * “orderId + result + amount + mode + errorCode + errorMessage + transactionDate + publicKey + privateKey”
	 * alanlarını birbirlerine, verilen sıra ile ekleyerek, SHA1 kriptografik hash fonksiyonun base64 methodu ile
	 * encode edilmesi sonucunda bu değer oluşur.
	 *
	 * Not 1: İşlem sonucunda sizlere gönderilen hash bilgisini tarafınıza gelen parametreler ile tekrar hesaplayıp
	 * bu alandaki bilgi ile karşılaştırılması gerekmektedir.
	 * Eğer aynı hash değeri oluşmuyor ise işlemi reddetmelisiniz.
	 * Aksi durumda cevap bilgisi iletiminde üçüncü kişilerin araya girerek sahtekarlık yapabilme olasılığı
	 * ortaya çıkacaktır.
	 *
	 * Not 2: Hash bilgisi hesaplamasında null olan veriler, String “” olarak hesaplanmıştır.
	 *
	 * Not 3: İstek bilgileri içerisinde mağazanın tanımamasından kaynaklı olarak mağaza bilgileri yoksa
	 * cevap bilgisinde hash ve transactionDate alanları gönderilmeyecektir.
	 *
	 * @var
	 */
	public $hash;
}
