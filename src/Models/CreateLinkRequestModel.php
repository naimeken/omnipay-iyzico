<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/home/PaymentServices#payByLink
 */
class CreateLinkRequestModel extends BaseModel
{
	/**
	 * İstekte bulunan kullanıcının IP adresi
	 *
	 * @required
	 * @var
	 */
	public $clientIp;

	/**
	 * Müşteri isim bilgisi 2 ila 50 arasında Türkçe karakterlerden oluşmalıdır.
	 * Boşluk karakteri kabul edilir.
	 *
	 * @required
	 * @var
	 */
	public $name;

	/**
	 * Müşteri soyisim bilgisi 2 ila 50 arasında Türkçe karakterlerden oluşmalıdır.
	 * Boşluk karakteri kabul edilir.
	 *
	 * @required
	 * @var
	 */
	public $surname;

	/**
	 * Müşteri T.C. kimlik numarası bilgisi Müşteriye ait 11 rakamdan oluşan T.C. Kimlik No
	 *
	 * @var
	 */
	public $tcCertificate = "11111111111";

	/**
	 * Müşteri vergi numarası bilgisi Müşteriye ait 10 rakamdan oluşan T.C. Vergi Numarası
	 *
	 * @var
	 */
	public $taxNumber = "1111111111";

	/**
	 * Müşterinin ödeme linkini alacağı e-posta adresi
	 *
	 * @var
	 * @required
	 */
	public $email;

	/**
	 * Müşteriye ait cep telefonu numarası bilgisi.
	 * 10 hane olarak gönderilmelidir.
	 * Örn; 5881231212
	 *
	 * @var
	 * @required
	 */
	public $gsm;

	/**
	 * Müşteriden tahsil edilecek olan tutar bilgisi Tutar kuruş ayracı olmadan gönderilmelidir. Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilmelidir.
	 *
	 * @var
	 * @required
	 */
	public $amount;

	/**
	 * 3D Secure ile gerçekleştirilen ödeme işlemlerinde “true” olarak gönderilmelidir.
	 *
	 * @var
	 * @required
	 */
	public $threeD;

	/**
	 * Link geçerlilik süresidir. “yyyy-MM-dd HH:mm:ss” formatında olmalıdır.
	 *
	 * @var
	 * @required
	 */
	public $expireDate;

	/**
	 * Ödemenin geçebileceği taksitlerin listesidir.
	 * Örnek: 2,3,4,5,9 şeklinde olmalıdır.
	 * Bu listenin boş veya hiç gönderilmediği durumlarda işlem peşin olarak kabul edilir.
	 *
	 * @var
	 */
	public $installmentList;

	/**
	 * Kullanıcıya email gönderilmesi isteniyor ise bu alan “true” istenmiyor ise “false” gönderilmelidir.
	 *
	 * @var
	 */
	public $sendEmail = true;

	/**
	 * Oluşturulmak istenen linkin mod bilgisi. “P” veya “T” gönderilmelidir.
	 * “P” - Gerçek Linki
	 * “T” – Test Linki
	 *
	 * @var
	 * @required
	 */
	public $mode;

	/**
	 * İpara komisyonunun Alıcıya veya Satıcıya yansıtılması.
	 * “1” veya “2” gönderilmelidir.
	 * Bu parametrenin gönderilmemesi veya boş gönderilmesi durumlarında komisyon satıcıdan tahsil edilir.
	 * “1” – Satıcı
	 * “2” – Alıcı
	 *
	 * @var int
	 */
	public $commissionType = 1;
}
