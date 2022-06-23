<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://dev.ipara.com.tr/home/PaymentServices#payByLink
 */
class DeleteLinkRequestModel extends BaseModel
{
	/**
	 * @required
	 * @var
	 */
	public $clientIp;

	/**
	 * @required
	 * @var
	 */
	public $linkId;
}
