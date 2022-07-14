<?php

namespace Omnipay\Iyzico\Models;

class VerifyEnrolmentRequestModel extends BaseModel
{
    public function __construct(?array $abstract)
    {
        parent::__construct($abstract);
    }

    public string $status;
    public string $paymentId;
    public ?string $conversationData;
    public string $conversationId;
    public int $mdStatus;
}
