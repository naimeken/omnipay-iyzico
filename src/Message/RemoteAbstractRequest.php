<?php

namespace Omnipay\Iyzico\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Iyzico\Traits\PurchaseGettersSetters;

/**
 * Iyzico Purchase Request
 */
abstract class RemoteAbstractRequest extends AbstractRequest
{
    use PurchaseGettersSetters;

    protected function get_card($key)
    {
        return $this->getCard() ? $this->getCard()->$key() : null;
    }

    abstract protected function createResponse($data);
}
