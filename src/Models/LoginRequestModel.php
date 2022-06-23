<?php

namespace Omnipay\Iyzico\Models;

/**
 * @link https://documenter.getpostman.com/view/10639199/SzRw3Bnj
 */
class LoginRequestModel extends BaseModel
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
	public $corporateNumber;

	/**
	 * @required
	 * @var
	 */
	public $username;

	/**
	 * @required
	 * @var
	 */
	public $password;
}
