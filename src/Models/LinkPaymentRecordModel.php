<?php

namespace Omnipay\Iyzico\Models;

class LinkPaymentRecordModel extends BaseModel
{
    /**
     * Müşteriye iletilen tutar bilgisi Tutar kuruş ayracı olmadan gönderilecektir.
     * Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilecektir.
     *
     * @var
     */
    public $amount;

    /**
     * Ödeme Linki’nin yaratıldığı tarih “yyyy-MM-dd HH:mm:ss“ formatında.
     *
     * @var
     */
    public $creationDate;

	/**
	 * Ödeme Linki’nin gönderildiği e-posta adresi.
	 *
	 * @var
	 */
	public $email;

	/**
	 * Ödeme Linki gönderim isteğinde iletilen cep telefonu numarası.
	 *
	 * @var
	 */
	public $gsm;

    /**
     * Ödeme Linkinin durumu
     *
     * 0 - Link İsteği Alındı
     * 1 - Link URL’i yaratıldı
     * 2 - Link Gönderildi, Ödeme Bekleniyor
     * 3 - Link ile Ödeme Başarılı
     * 98 - Link Zaman Aşımına Uğradı
     * 99 - Link Silindi
     *
     * @var int
     */
    public $linkState;

	/**
	 * Ödeme Linkinin ID’si.
	 * Bu bilgi link silme servisinde kullanılabilmektedir.
	 *
	 * @var
	 */
	public $linkId;

	/**
	 * Ödeme Linki gönderim isteğinde belirtilen müşteri adı.
	 *
	 * @var
	 */
	public $name;

	/**
	 * Ödeme Linki gönderim isteğinde belirtilen müşteri soyadı.
	 *
	 * @var
	 */
	public $surname;

	/**
	 * Ödeme Linki gönderim isteğinde belirtilen T.C. vergi numarası.
	 *
	 * @var
	 */
	public $taxNumber;

	/**
	 * Ödeme Linki gönderim isteğinde belirtilen T.C. Kimlik Numarası.
	 *
	 * @var
	 */
	public $tcCertificate;
}
