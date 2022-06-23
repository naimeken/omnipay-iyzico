<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/Home/WalletServices#getcardsfromwallet
 */
class CardInquiryRequestModel extends BaseModel
{
	/**
	 * Mağaza kullanıcısını referans eden bilgi.
	 *
	 * @required
	 * @var
	 */
	public $userId;

	/**
	 * cardId Tanımlanmış karta ait iPara referans bilgisi. Bu bilgi ödeme tahsilatlarında kullanılacaktır.
	 * - Alan dolu olarak gönderilir ise sadece ilgili karta ait veriler dönülecektir.
	 * - Alan boş olarak gönderilir ise kullanıcının tüm kartları dönülecektir.
	 *
	 * @var
	 */
	public $cardId;

	/**
	 * Müşteri istemci IP adresi.
	 *
	 * @required
	 * @var
	 */
	public $clientIp;
}
