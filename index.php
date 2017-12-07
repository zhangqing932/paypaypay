<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './connectors/fuyinbao/pay.php';
include_once './connectors/fuyinbao/paytype.php';
include_once './monney.php';


$third = new pay();
$third->Monney = new Monney();
$third->Monney->base_money = 100;
$third->Pay_type = PayType::PAY_TYPE_WECHAT;
$third->Order_id = 'xqwertbgsj1987654341'.rand(100,999);

$third->Keys['merchant_private_key']    = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBANAqE2Bb5zKFyA/O
604+fmzgfwm2/EweP+SE0RpfHPXmgo0d39Y0rH53pVRDGp13OApNlmGH18CxRdIM
z3QSN+loAFMqvp483YHLwf5CDm/UiWAIdrbhahDWgmJsNrHZWkJe1zfyEgNfQCYj
018ngGOYRfEw4HebC2L+791M8TI7AgMBAAECgYEAmvfH5wNkEaugrYwYhu5lRf62
9G+CUdRvMltiI+TM9Y8+f3nPCnO6Oogtz5YJOVLoqFrsaf0sNGqElQQuaLWrYsHm
XYFbfatg8DIisQ7zJjf+KGbvI6hSlAlL+3nxGWqwfNxQLX64AE+MDkpIA8OAqwmz
sCScFBnB8zFJLXWjAskCQQD5hKXj8xdg9nJV7soG3tI0OXMJ1PdHJOjustwgoz8y
amK8nZfocvLT3MNFLY1IxnjQ4hkpufM38ehaKTvK7n/9AkEA1ZJqZLbDkYWfz/nL
mdj5mKukiYTxsFlAFbDotxXw4zdMmy7tZrEHziJsQ/ZLSkNR1byq1U6nUrO+XdVY
VT7ElwJAX1t4YpNGfgHxVDH794A0aU0DT+CZ2BCdDIxCYB7DSisqLNc1dNppPtqB
rfBorEVdasbdwvqTnu/OUpariTR4qQJADPaoMpjNYiXkP3GAJESBUf0JLbe+G+Au
/aIRXhuc1Y3jvn+otVUFjkOUosNuaoGPlBOxouT1TxXN9lAe3n3C3QJAStxosFHW
FZ3U82SJ2oNeol5f4j61bKhCaBy2qdnoFKIOeYzS5NbXjoYQ1Q1Xt41xTatZ1Brz
Qy5y9OjmcSThpg==
-----END PRIVATE KEY-----
';
$third->Keys['server_public_key']       = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDJuWvoRtBJ3fLiS2NeYbM7jq9/
a+i/4pcWUAJUFaPWJ6Wy0LO77LDztN23wqm3Wyjh69MxJwKNbHa5ieEjcxjM0AGT
aIjAaWZq+57K9sZXlPmBSRiAyxI03iVtLqB/ZWDNjsMlKHho268PYAgGgtJBZWVW
VNv07Flv3kynJTNkSwIDAQAB
-----END PUBLIC KEY-----
';

$third->Merchant = '126074';


$third->pay();

/*******************************************回调示例****************************************************/

$call = new pay();
$str = '{"opay_status":"0","order_type":"2701","out_trade_no":"20171206224352246164","pay_status":"1","seller_id":"126071","sign":"kqnxHQ1+J5WpyTqQQXpaFZpd5xNryuCq6Vn0SAL5egvyiL6okA/tg46Tj4HOZDrc539WV0vG711wj3Ec82uVieW9ost1eZaDVlp3WyktUIOIeSUcgQW1tC6DCsCcBYnleLdPR35Y9Fyt1/LywU2AtQPkK3Lu3UbQNCa9lEwoZZY=","total_fee":200}';
$order_id = $call->getOrderId();
$merchant = $call->getOrderMerchant();

/***
 * 根据账号取得key
 */
$key = function($merchant , $order_id){
    return $k = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDJuWvoRtBJ3fLiS2NeYbM7jq9/
a+i/4pcWUAJUFaPWJ6Wy0LO77LDztN23wqm3Wyjh69MxJwKNbHa5ieEjcxjM0AGT
aIjAaWZq+57K9sZXlPmBSRiAyxI03iVtLqB/ZWDNjsMlKHho268PYAgGgtJBZWVW
VNv07Flv3kynJTNkSwIDAQAB
-----END PUBLIC KEY-----
';
};

$call->Keys['server_public_key'] = $key($merchant , $order_id);

$call->callback();
