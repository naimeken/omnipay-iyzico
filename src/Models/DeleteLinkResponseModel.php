<?php

namespace Omnipay\Iyzico\Models;

class DeleteLinkResponseModel extends BaseModel
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
	 * Kullanıcıya gösterilecek hata veya başarılı sonuç mesajı.
	 * Başarılı entegrasyon sonrası hata mesajlarının kullanıcıya direkt gösterilmesini öneririz.
	 *
	 * @var
	 */
	public $responseMessage;
}
