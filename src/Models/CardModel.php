<?php

namespace Omnipay\Iyzico\Models;

class CardModel extends BaseModel
{
	/**
	 * Tanımlanmış karta ait iPara referans bilgisi.
	 * Bu bilgi ödeme tahsilatlarında kullanılacaktır.
	 *
	 * @var
	 */
	public $cardId;

	/**
	 * Kayıtlı kartın maskelenmiş numara bilgisi
	 *
	 * @var
	 */
	public $maskNumber;

	/**
	 * Kayıtlı kartın rumuz bilgisi
	 *
	 * @var
	 */
	public $alias;

	/**
	 * Banka id bilgisi. Tüm Türkiye de geçerli olan banka ID bilgisidir.
	 *
	 * @var
	 */
	public $bankId;

	/**
	 * Banka adı bilgisi
	 *
	 * @var
	 */
	public $bankName;

	/**
	 * Kart aile bilgisi
	 *
	 * @var
	 */
	public $cardFamilyName;

	/**
	 * Taksit destekleme durumu
	 * 0 – Kart taksitli işlem desteklememektedir.
	 * 1 – Kart taksitli işlem desteklemektedir.
	 *
	 * @var
	 */
	public $supportsInstallment;

	/**
	 * Desteklenen taksit dizisi.
	 * Bu alan değeri hem mağazanın taksit aktifliği hem de kartın taksit desteğine göre hesaplanmaktadır.
	 *
	 * @var
	 */
	public $supportsInstallments;

	/**
	 * Desteklenen taksit dizisi.
	 * Bu alan değeri hem mağazanın taksit aktifliği hem de ilgili bin
	 * numarasının taksit desteğine göre hesaplanmaktadır.
	 * Ek olarak eğer kart Ticari kart ise taksit bilgisi mağaza taksit
	 * aktifliğine bakılmaksızın hesaplanmaktadır.
	 *
	 * @var
	 */
	public $supportedInstallments;

	/**
	 * Kart tipi
	 * 0 – Kart tipi bilinmiyor
	 * 1 – Kredi Kartı
	 * 2 – Debit Kart
	 *
	 * @var
	 */
	public $type;

	/**
	 * Servis sağlayıcısı
	 * 0 – Servis sağlayıcı bilinmiyor.
	 * 1 – Mastercard
	 * 2 – Visa
	 * 3 – Amex
	 * 4 - Troy
	 *
	 * @var
	 */
	public $serviceProvider;

	/**
	 * Kayıtlı kartın 3D güvenlik adımı zorunluluğu.
	 * Ödeme sırasında 3D secure işlem yapılması zorunluluğu,
	 * bu alan değeri hem mağazanın 3D Secure zorunluluğuna hem de kart
	 * ailesinin 3D Secure zorunluluğuna bağlı olarak zorunlu olabilir.
	 * 0 – 3D Secure zorunlu değil.
	 * 1 – 3D Secure zorunlu
	 *
	 * @var
	 */
	public $threeDSecureMandatory;

	/**
	 * Kayıtlı kartın cvc zorunluluğu.
	 * Ödeme sırasında cvc bilgisinin gönderilmesi zorunluluğu,
	 * bu alan değeri hem mağazanın cvc zorunluluğuna hem de kart ailesinin cvc zorunluluğuna bağlı olarak zorunlu olabilir.
	 * 0 – CVC/CVV’siz ödeme kabulü yapılabilir.
	 * 1 – CVC/CVV gönderimi zorunludur.
	 *
	 * @var
	 */
	public $cvcMandatory;
}
