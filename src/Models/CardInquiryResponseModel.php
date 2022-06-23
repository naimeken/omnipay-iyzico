<?php

namespace Omnipay\Iyzico\Models;

class CardInquiryResponseModel extends BaseModel
{
	public function __construct(?array $abstract)
	{
		parent::__construct($abstract);

		if (!empty($this->cards)) {

			foreach ($this->cards as $key => $card) {

				$this->cards[$key] = new CardModel((array)$card);

			}

		}
	}

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
	 * Müşteri hata mesajı
	 *
	 * @var
	 */
	public $responseMessage;

	/**
	 * Hata Kodu
	 *
	 * @var
	 */
	public $errorCode;

	/**
	 * Banka id bilgisi. Tüm Türkiye de geçerli olan banka ID bilgisidir.
	 *
	 * @var CardModel[]
	 */
	public $cards;
}
