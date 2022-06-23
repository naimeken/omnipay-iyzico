<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/home/PaymentServices#payOtorizasyon
 */
class CaptureRequestModel extends BaseModel
{
	/**
	 * İstek modu. “P” veya “T” gönderilmelidir.
	 * "P" - Gerçek Ödeme
	 * “T” – Test Ödemesi
	 * Entegrasyon işlemlerinizde mode alanını “T” olarak göndererek test işlemlerinizi gerçekleştirebilirsiniz.
	 * ÖNEMLİ NOT: Test modunda iken ödemeler banka poslarından tahsil edilmez. Test işlemleriniz sonunda gerçek ödeme tahsilatı için mode alanını “P” olarak göndermeyi unutmayınız.
	 *
	 * @required
	 * @var
	 */
	public $mode;

	/**
	 * Mağazanın ilgili sipariş ile ilişkilendirdiği her bir istek için benzersiz olan tekil sipariş kodu.
	 * Maksimum Uzunluk: 100 karakter.
	 *
	 * @var
	 * @required
	 */
	public $orderId;

	/**
	 * Karttan çekilecek olan toplam sipariş tutarı.
	 * Sipariş tutarı kuruş ayracı olmadan gönderilmelidir.
	 * Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilmelidir.
	 *
	 * @required
	 * @var
	 */
	public $amount;

	/**
	 * Müşteri istemci IP adresi
	 *
	 * @required
	 * @var
	 */
	public $clientIp;

	public $name;

	public $surname;

	public $email;
}
