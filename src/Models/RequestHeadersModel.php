<?php

namespace Omnipay\Iyzico\Models;

/**
 * iPara, güvenlik kontrolleri için, mağazadan bazı bilgileri HTTP Header alanında istemektedir.
 * Aşağıda bu bilgilerin tanımları bulunmaktadır:
 */
class RequestHeadersModel extends BaseModel
{
    /**
     * İstek zamanı. "yyyy-MM-dd HH:mm:ss" formatındadır.
     * İşlem zaman aşımına uğramış ise istek reddedilir.
     * Örnek: "2014-08-12 23:59:59" İlgili kütüphane içindeki GetTransactionDate() fonksiyonundan elde edilebilir.
     *
     * @required
     * @var string
     */
    public $transactionDate;

    /**
     * Entegrasyon versiyon bilgisidir. "1.0" olarak gönderilmelidir.
     *
     * @var string
     */
    public $version = "1.0";

    /**
     * "publicKey:hash" bilgisidir.
     * Hash bilgisi;
     * "privateKey + userId + cardOwnerName + cardNumber + cardExpireMonth + cardExpireYear + clientIp + transactionDate"
     * alanlarını birbirlerine, verilen sıra ile ekleyerek,
     * SHA1 kriptografik hash fonksiyonun base64 methodu ile encode edilmesi sonucunda oluşur.
     * Hash oluşturma fonksiyonu örnekleri burada anlatılmıştır.
     *
     * token = public key + ‘:’ + base64[ sha1[("privateKey + userId + cardOwnerName + cardNumber + cardExpireMonth + cardExpireYear + clientIp + transactionDate")]]
     * token = "ASKJH98675ASDASDPO:jhsa/gd+89dfg0df6SA/dfg8967=="
     * @var string
     */
    public $token;
}
