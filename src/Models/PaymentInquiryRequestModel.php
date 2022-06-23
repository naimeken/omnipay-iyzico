<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/Home/PaymentServices#paymentInqury
 */
class PaymentInquiryRequestModel extends BaseModel
{
	/**
	 * İstek modu. “P” veya “T” gönderilmelidir.
	 * “P” - Gerçek Ödeme
	 * “T” – Test Ödemesi
	 * Entegrasyon işlemlerinizde mode alanını “T” olarak göndererek test işlemlerinizi gerçekleştirebilirsiniz.
	 * ÖNEMLİ NOT: Test modunda iken ödemeler banka poslarından tahsil edilmez.
	 * Test işlemleriniz sonunda gerçek ödeme tahsilatı için mode alanını “P” olarak göndermeyi unutmayınız.
	 *
	 * @required
	 * @var
	 */
	public $mode = "T";

	/**
	 * Mağazanın ilgili sipariş ile ilişkilendirdiği her bir istek için benzersiz olan tekil sipariş kodu.
	 * Maksimum Uzunluk: 100 karakter.
	 *
	 * @var
	 * @required
	 */
	public $orderId;

	/**
	 * Mağazaya istek sonucunda geri gönderilecek bilgi alanıdır. Maksimum Uzunluk: 255.
	 *
	 * @var
	 */
	public $echo;
}
