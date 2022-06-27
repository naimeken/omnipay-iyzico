<?php

namespace Omnipay\Iyzico\Traits;

trait PurchaseGettersSetters
{
	public function getPrivateKey()
	{
		return $this->getParameter('privateKey');
	}

	public function setPrivateKey($value)
	{
		return $this->setParameter('privateKey', $value);
	}

	public function getPublicKey()
	{
		return $this->getParameter('publicKey');
	}

	public function setPublicKey($value)
	{
		return $this->setParameter('publicKey', $value);
	}

	public function getLanguage()
	{
		return $this->getParameter('language');
	}

	public function setLanguage($value)
	{
		return $this->setParameter('language', $value);
	}

	public function getSecure()
	{
		return $this->getParameter('secure');
	}

	public function setSecure($value)
	{
		return $this->setParameter('secure', $value);
	}
	public function getEndpoint()
	{
		return ($this->getTestMode() ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com') . $this->endpoint;
	}

    public function getRandomString()
    {
        return $this->getParameter('randomString');
    }

    public function setRandomString($value)
    {
        return $this->setParameter('randomString', $value);
    }
}
