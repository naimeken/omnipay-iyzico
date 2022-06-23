<?php

namespace Omnipay\Iyzico\Models;

class PaymentModel extends BaseModel
{
	/**
	 * Ödeme durumunu belirten sonuç bilgisi.
	 * 0 – Entegrasyon Hatası
	 * 1 – Ödeme başarılı
	 * 2 – Ödeme iade edilmiş
	 * 3 – Ödeme reddedilmiş
	 * 4 – Ödeme bulunamadı
	 * 6 – Parçalı iade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * 7 – İade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
	 * 8 – İade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 * 9 – Parçalı iade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
	 *
	 * @var
	 */
    public $result;

    /**
     * Ödeme durumunu belirten mesajdır
     * APPROVED – Ödeme başarılı
     * REFUNDED – Ödeme iade edilmiş
     * DECLINED – Ödeme rededilmiş
     * NOT_FOUND – Ödeme bulunamadı
     * APPROVED_BUT_WAITING_MANUAL_PARTIAL_REFUND - Parçalı iade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
     * APPROVED_BUT_WAITING_MANUAL_REFUND – İade talebinde bulunulmuş ancak iPara tarafından manuel iade yapılması gerekiyor.
     * APPROVED_BUT_WAITING_MONEY_TRANSFER_FOR_REFUND – İade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
     * APPROVED_BUT_WAITING_MONEY_TRANSFER_FOR_PARTIAL_REFUND – Parçalı iade talebinde bulunulmuş ancak Mağaza’dan geri para transferi yapılması gerekiyor.
     *
     * @var
     */
    public $responseMessage;

    /**
     * @var
     */
    public $orderId;

    /**
     * Initial payment
     *
     * @var
     */
    public $amount;

    /**
     * Amount after modifications like partial refunds etc.
     *
     * @var
     */
    public $finalAmount;

    /**
     * Like 2020-06-08 10:07:52.0
     *
     * @var
     */
    public $transactionDate;
}
