<?php

namespace Omnipay\Iyzico\Models;

class DeleteCardResponseModel extends BaseModel
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
	 * Kullanıcıya gösterilecek mesaj
	 * - Banka kartınız silinmiştir.
	 * - Kullanıcı kartları silinmiştir.
	 *
	 * @var string
	 */
	public $responseMessage;
}
