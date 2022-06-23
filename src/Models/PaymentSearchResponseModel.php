<?php

namespace Omnipay\Iyzico\Models;

class PaymentSearchResponseModel extends BaseModel
{
	public function __construct(?array $abstract)
	{
		parent::__construct($abstract);

		if (!empty($this->payments)) {

			foreach ($this->payments as $key => $payment) {

				$this->payments[$key] = new PaymentModel((array)$payment);

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
	 * Hata Kodu
	 *
	 * @var
	 */
	public $errorCode;

	/**
	 * Tarih aralığında bulunan tüm ödemelerin bilgileri
	 *
	 * @var PaymentModel[]
	 */
	public $payments;

	/**
	 * Tarih aralığında bulunan toplam ödeme sayısı
	 *
	 * @var
	 */
	public $totalPayments;

	/**
	 * İşlem sonucunu bildiren mesajdır.
	 *
	 * @var
	 */
	public $responseMessage;
}
