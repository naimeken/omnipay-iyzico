<?php

namespace Omnipay\Iyzico\Models;

class BinLookupResponseModel extends BaseModel
{
    /**
     * İşlem sonucu
     * 1 - İşlem Başarılı
     * 0 - İşlem Başarısız
     *
     * @var
     */
    public $result;

    /**
     * Hata Mesajı
     *
     * @var
     */
    public $errorMessage;

    /**
     * Hata Kodu
     *
     * @var
     */
    public $errorCode;

    /**
     * Banka id bilgisi. Tüm Türkiye de geçerli olan banka ID bilgisidir.
     *
     * @var
     */
    public $bankId;

    /**
     * Banka adı bilgisi
     *
     * @var
     */
    public $bankName;

    /**
     * Kart aile bilgisi
     *
     * @var
     */
    public $cardFamilyName;

    /**
     * Taksit destekleme durumu
     * 0 – Kart taksitli işlem desteklememektedir.
     * 1 – Kart taksitli işlem desteklemektedir.
     *
     * @var
     */
    public $supportsInstallment;

    /**
     * Desteklenen taksit dizisi.
     * Bu alan değeri hem mağazanın taksit aktifliği hem de ilgili bin
     * numarasının taksit desteğine göre hesaplanmaktadır.
     * Ek olarak eğer kart Ticari kart ise taksit bilgisi mağaza taksit
     * aktifliğine bakılmaksızın hesaplanmaktadır.
     *
     * @var
     */
    public $supportedInstallments;

    /**
     * Kart tipi
     * 0 – Kart tipi bilinmiyor
     * 1 – Kredi Kartı
     * 2 – Debit Kart
     *
     * @var
     */
    public $type;

    /**
     * Servis sağlayıcısı
     * 0 – Servis sağlayıcı bilinmiyor.
     * 1 – Mastercard
     * 2 – Visa
     * 3 – Amex
     * 4 - Troy
     *
     * @var
     */
    public $serviceProvider;

    /**
     * 3D güvenlik adımı zorunluluğu.
     * Bu alan değeri kart ailesinin 3D Secure zorunluluğuna bağlı olarak zorunlu olabilir.
     * 0 – 3D Secure zorunlu değil.
     * 1 – 3D Secure zorunlu
     *
     * @var
     */
    public $cardThreeDSecureMandatory;

    /**
     * 3D güvenlik adımı zorunluluğu.
     * Bu alan değeri mağazanın 3D Secure zorunluluğuna bağlı olarak zorunlu olabilir.
     * 0 – 3D Secure zorunlu değil.
     * 1 – 3D Secure zorunlu
     *
     * @var
     */
    public $merchantThreeDSecureMandatory;

    /**
     * CVC/CVV bilgisinin gönderim zorunluluğu.
     * Bu alan değeri hem mağazanın cvc zorunluluğuna hem de kart ailesinin cvc zorunluluğuna bağlı olarak zorunlu olabilir.
     * 0 – CVC/CVV’siz ödeme kabulü yapılabilir.
     * 1 – CVC/CVV gönderimi zorunludur.
     *
     * @var
     */
    public $cvcMandatory;

    /**
     * Ticari kart bilgisi
     * 1 – Ticari kart
     * 0 – Bireysel kart
     * Ticari kartlar ile mağaza taksit aktifliği kapalı olsa dahi taksit yapılabilir.
     * Desteklenen taksitler için supportedInstallments alanını kullanabilirsiniz.
     *
     * @var
     */
    public $businessCard;

    /**
     * Taksit Sayısı.
     * Taksit sayısı en fazla 12 olacak şekilde (1-12) arası değerler gelmektedir.
     *
     * @var
     */
    public $installmentDetail;
}
