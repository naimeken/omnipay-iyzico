<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Iyzico\Message\ChargeRequest;
use Omnipay\Iyzico\Traits\PurchaseGettersSetters;

/**
 * Iyzico Gateway
 * (c) Tolga Can Günel
 * 2015, mobius.studio
 * http://www.github.com/tcgunel/omnipay-iyzico
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 */
class Gateway extends AbstractGateway
{
	use PurchaseGettersSetters;

	public function getName(): string
	{
		return 'Iyzico';
	}

	public function getDefaultParameters()
	{
		return [
			"clientIp" => "127.0.0.1",

			"installment"   => "1",
			"secure"        => false,
			"publicKey"     => "",
			"privateKey"    => "",
			"language"      => ["tr", "en"],
            "randomString"       => "123456789",

		];
	}

    public function binLookup(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\BinLookupRequest', $parameters);
    }

    public function purchase(array $parameters = [])
    {
        if (
            (array_key_exists('secure', $parameters) && $parameters["secure"] === true) ||
            $this->getSecure() === true
        ) {

            return $this->createRequest('\Omnipay\Iyzico\Message\EnrolmentRequest', $parameters);

        }

        return $this->createRequest(ChargeRequest::class, $parameters);
    }
}
