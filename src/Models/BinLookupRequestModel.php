<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/Home/PaymentServices#binInqury
 */
class BinLookupRequestModel extends BaseModel
{
	/**
	 * Amount to calculate installments etc.
	 *
	 * @required
	 * @var
	 */
	public $amount;

	/**
	 * Kredi veya Debit Kart numarasının ilk 6 hanesi. Örnek: 428220
	 *
	 * @var
	 * @required
	 */
	public $binNumber;

	/**
	 * @required
	 * @var bool
	 */
	public $threeD;
}
