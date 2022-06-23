[![License](https://poser.pugx.org/tcgunel/omnipay-iyzico/license)](https://packagist.org/packages/tcgunel/omnipay-iyzico)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/tcgunel/omnipay-iyzico)
[![PHP Composer](https://github.com/tcgunel/omnipay-iyzico/actions/workflows/tests.yml/badge.svg)](https://github.com/tcgunel/omnipay-iyzico/actions/workflows/tests.yml)

# Omnipay Iyzico Gateway
Omnipay gateway for Iyzico. All the methods of Iyzico implemented for easy usage.

## Requirements
| PHP       | Package |
|-----------|---------|
| ^7.3-^8.0 | v1.0.0  |

## Installment

```
composer require tcgunel/omnipay-iyzico
```

## Usage

Please see the [Wiki](https://github.com/tcgunel/omnipay-iyzico/wiki) page for detailed usage of every method.

## Methods
#### Payment Services

* binLookup($options) // [Bin Sorgulama](https://dev.ipara.com.tr/Home/PaymentServices#binInqury)
* purchase($options) // [3D Secure](https://dev.ipara.com.tr/Home/PaymentServices#securePaymentOneStep) ile yada [3D Secure olmadan](https://dev.ipara.com.tr/Home/PaymentServices#apiPayment) ödeme.
* paymentInquiry($options) // [Ödeme Sorgulama](https://dev.ipara.com.tr/Home/PaymentServices#paymentInqury)
* paymentSearch($options) // [Ödeme Sorgulama (Tarih Aralığı Parametreli)](https://dev.ipara.com.tr/Home/PaymentServices#paymentInqury)
* createLink($options) // [Link ile Ödeme](https://dev.ipara.com.tr/Home/PaymentServices#payByLink)
* listLink($options) // [Link Sorgulama](https://dev.ipara.com.tr/Home/PaymentServices#payByLink)
* deleteLink($options) // [Link Silme](https://dev.ipara.com.tr/Home/PaymentServices#payByLink)
* authorize($options) // [Ön Otorizasyon Servisi](https://dev.ipara.com.tr/Home/PaymentServices#payOtorizasyon)
* capture($options) // [Ön Provizyon Kapama Servisi](https://dev.ipara.com.tr/Home/PaymentServices#payOtorizasyon)

#### Wallet Services

* createCard($options) // [Kart Ekleme Servisi](https://dev.ipara.com.tr/Home/WalletServices#addcardtowallet)
* listCard($options) // [Kartları Getir Servisi](https://dev.ipara.com.tr/Home/WalletServices#getcardsfromwallet)
* deleteCard($options) // [Kart Sil Servisi](https://dev.ipara.com.tr/Home/WalletServices#deletecardfromwallet)


#### Other Services

* login($options) // [SessionToken](https://documenter.getpostman.com/view/10639199/SzRw3Bnj)


## Tests
```
composer test
```
For windows:
```
vendor\bin\paratest.bat
```

## Treeware

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/tcgunel/omnipay-iyzico) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.
