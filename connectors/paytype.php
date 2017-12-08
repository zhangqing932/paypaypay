<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PayType extends AbstractPayType{
    
    static public $type_maps = [
        self::PAY_TYPE_WECHAT => 2701 , 
        self::PAY_TYPE_ALIPAY => 2702 ,
        self::PAY_TYPE_QQPAY  => 2705 ,
        self::PAY_TYPE_BANK   => 2704   
    ];
    
    
    
    
}

