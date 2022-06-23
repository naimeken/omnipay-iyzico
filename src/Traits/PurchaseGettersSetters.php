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

	public function getVersion()
	{
		return $this->getParameter('version');
	}

	public function setVersion($value)
	{
		return $this->setParameter('version', $value);
	}

	public function getTaxOffice()
	{
		return $this->getParameter('taxOffice');
	}

	public function setTaxOffice($value)
	{
		return $this->setParameter('taxOffice', $value);
	}

	public function getUserReference()
	{
		return $this->getParameter('userReference');
	}

	public function setUserReference($value)
	{
		return $this->setParameter('userReference', $value);
	}

	public function getTaxNumber()
	{
		return $this->getParameter('taxNumber');
	}

	public function setTaxNumber($value)
	{
		return $this->setParameter('taxNumber', $value);
	}

	public function getNationalId()
	{
		return $this->getParameter('nationalId');
	}

	public function setNationalId($value)
	{
		return $this->setParameter('nationalId', $value);
	}

	public function getEcho()
	{
		return $this->getParameter('echo');
	}

	public function setEcho($value)
	{
		return $this->setParameter('echo', $value);
	}

	public function getSecure()
	{
		return $this->getParameter('secure');
	}

	public function setSecure($value)
	{
		return $this->setParameter('secure', $value);
	}

	public function getInstallment()
	{
		return $this->getParameter('installment');
	}

	public function setInstallment($value)
	{
		return $this->setParameter('installment', $value);
	}

	public function getTransactionDate()
	{
		return $this->getParameter('transactionDate');
	}

	public function setTransactionDate($value)
	{
		return $this->setParameter('transactionDate', $value);
	}

	public function getDeviceUUID()
	{
		return $this->getParameter('deviceUUID');
	}

	public function setDeviceUUID($value)
	{
		return $this->setParameter('deviceUUID', $value);
	}

	public function getVendorId()
	{
		return $this->getParameter('vendorId');
	}

	public function setVendorId($value)
	{
		return $this->setParameter('vendorId', $value);
	}

	public function getClientIp()
	{
		return $this->getParameter('clientIp');
	}

	public function setClientIp($value)
	{
		return $this->setParameter('clientIp', $value);
	}

	public function getEndpoint()
	{
		return $this->endpoint;
	}

	public function getCustomerRef()
	{
		return $this->getParameter('customerRef');
	}

	public function setCustomerRef($customerRef)
	{
		return $this->setParameter('customerRef', $customerRef);
	}

	public function getThreeDSecureCode()
	{
		return $this->getParameter('threeDSecureCode');
	}

	public function setThreeDSecureCode($value)
	{
		return $this->setParameter('threeDSecureCode', $value);
	}

	public function getCardAlias()
	{
		return $this->getParameter('cardAlias');
	}

	public function setCardAlias($value)
	{
		return $this->setParameter('cardAlias', $value);
	}

	public function getStartDate()
	{
		return $this->getParameter('startDate');
	}

	public function setStartDate($value)
	{
		return $this->setParameter('startDate', $value);
	}

	public function getEndDate()
	{
		return $this->getParameter('endDate');
	}

	public function setEndDate($value)
	{
		return $this->setParameter('endDate', $value);
	}

	public function getCorporateNumber()
	{
		return $this->getParameter('corporateNumber');
	}

	public function setCorporateNumber($value)
	{
		return $this->setParameter('corporateNumber', $value);
	}

	public function getUsername()
	{
		return $this->getParameter('username');
	}

	public function setUsername($value)
	{
		return $this->setParameter('username', $value);
	}

	public function getPassword()
	{
		return $this->getParameter('password');
	}

	public function setPassword($value)
	{
		return $this->setParameter('password', $value);
	}

	public function getExpireDate()
	{
		return $this->getParameter('expireDate');
	}

	public function setExpireDate($value)
	{
		return $this->setParameter('expireDate', $value);
	}

	public function getSendEmail()
	{
		return $this->getParameter('sendEmail');
	}

	public function setSendEmail($value)
	{
		return $this->setParameter('sendEmail', $value);
	}

	public function getCommissionType()
	{
		return $this->getParameter('commissionType');
	}

	public function setCommissionType($value)
	{
		return $this->setParameter('commissionType', $value);
	}

	public function getLinkState()
	{
		return $this->getParameter('linkState');
	}

	public function setLinkState($value)
	{
		return $this->setParameter('linkState', $value);
	}

	public function getPageSize()
	{
		return $this->getParameter('pageSize');
	}

	public function setPageSize($value)
	{
		return $this->setParameter('pageSize', $value);
	}

	public function getPageIndex()
	{
		return $this->getParameter('pageIndex');
	}

	public function setPageIndex($value)
	{
		return $this->setParameter('pageIndex', $value);
	}

	public function getLinkId()
	{
		return $this->getParameter('linkId');
	}

	public function setLinkId($value)
	{
		return $this->setParameter('linkId', $value);
	}
}
