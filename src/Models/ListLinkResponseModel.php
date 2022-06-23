<?php

namespace Omnipay\Iyzico\Models;

class ListLinkResponseModel extends BaseModel
{
	public function __construct(?array $abstract)
	{
		parent::__construct($abstract);

		if (!empty($this->linkPaymentRecordList)) {

			foreach ($this->linkPaymentRecordList as $key => $linkPaymentRecord) {

				$this->linkPaymentRecordList[$key] = new LinkPaymentRecordModel((array)$linkPaymentRecord);

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
	 * Link detay bilgileri listesi.
	 *
	 * @var LinkPaymentRecordModel[]
	 */
	public $linkPaymentRecordList;

	public $pageIndex;

	public $pageSize;

	public $pageCount;
}
