<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/Home/PaymentServices#paymentInqury
 */
class PaymentSearchRequestModel extends BaseModel
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
	public $mode;

	/**
	 * Sorgulanmak istenilen siparişler için tarih aralığının başlangıç değeri Örnek “2020-06-01 23:59:59”
	 *
	 * @var
	 * @required
	 */
	public $startDate;

	/**
	 * Sorgulanmak istenilen siparişler için tarih aralığının bitiş değeri Örnek “2020-06-30 23:59:59”
	 *
	 * @var
	 * @required
	 */
	public $endDate;

	/**
	 * Mağazaya istek sonucunda geri gönderilecek bilgi alanıdır. Maksimum Uzunluk: 255.
	 *
	 * @var
	 */
	public $echo;
}
