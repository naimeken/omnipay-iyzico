<?php

namespace Omnipay\Iyzico\Models;

class CreateLinkResponseModel extends BaseModel
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
	 * Kullanıcıya gösterilecek hata veya başarılı sonuç mesajı.
	 * Başarılı entegrasyon sonrası hata mesajlarının kullanıcıya direkt gösterilmesini öneririz.
	 *
	 * @var
	 */
	public $responseMessage;

    /**
     * İşlem başarılı sonuçlandığında oluşan url bilgisi.
     *
     * @var
     */
    public $link;

    /**
     * Ödeme Linkinin şifreli ID bilgisi. Bu bilgi link silme servisinde kullanılabilmektedir.
     *
     * @var
     */
    public $linkPaymentId;

    /**
     * İstek içinde alından tutar bilgisinin biçimlendirilmiş hali.
     * Tutar kuruş ayracı olmadan gönderilecektir.
     * Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilecektir.
     *
     * @var
     */
    public $amount;
}
