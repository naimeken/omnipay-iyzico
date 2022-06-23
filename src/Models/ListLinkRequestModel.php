<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/home/PaymentServices#payByLink
 */
class ListLinkRequestModel extends BaseModel
{
	/**
	 * İstekte bulunan kullanıcının IP adresi
	 *
	 * @required
	 * @var
	 */
	public $clientIp;

	/**
	 * Müşterinin ödeme linkini alacağı email adresi
	 *
	 * @var
	 */
	public $email;

	/**
	 * Müşteriye ait cep telefonu bilgisi
	 *
	 * @var
	 */
	public $gsm;

	/**
	 * Link durum bilgisi.
	 *
	 * 0 - Link İsteği Alındı
	 * 1 - Link URL’i yaratıldı
	 * 2 - Link Gönderildi, Ödeme Bekleniyor
	 * 3 - Link ile Ödeme Başarılı
	 * 98 - Link Zaman Aşımına Uğradı
	 * 99 - Link Silindi
	 *
	 * @var
	 */
	public $linkState;

	/**
	 * Link oluşturma alanına ait arama başlangıç tarihi.
	 * “yyyy-MM-dd HH:mm:ss” formatındadır.
	 *
	 * @var
	 */
	public $startDate;

	/**
	 * Link oluşturma alanına ait arama bitiş tarihi.
	 * “yyyy-MM-dd HH:mm:ss” formatındadır.
	 *
	 * @var
	 */
	public $endDate;

	/**
	 * Toplam gösterilebilecek sayfa adedidir.
	 * 5 ile 15 değerlerine eşit ya da arasında olmalıdır.
	 *
	 * @var
	 * @required
	 */
	public $pageSize;

	/**
	 * Gösterilecek sayfa indeksi/numarasıdır.
	 * Cevap olarak dönülecek olan “pageCount” bilgisi kullanılarak mümkün diğer sayfa indekslerine ulaşılabilir.
	 *
	 * @var
	 * @required
	 */
	public $pageIndex;
}
