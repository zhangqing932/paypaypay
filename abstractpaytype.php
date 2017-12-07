<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 只是一个转换格式 不提供实际转换记录
 */

class AbstractPayType{
    
    const PAY_TYPE_WECHAT = 1;
    const PAY_TYPE_ALIPAY = 2;
    const PAY_TYPE_QQPAY  = 3;
    const PAY_TYPE_BANK   = 4;
    
    /**
     *三方的具体编码继承这个类  
     *这里的key集合为转换的标准编码
     * @var Array 
     */
    static public $bank_maps = [
       'ICBC',
       'ABC',
       'BBC'   
    ];
    
     /**
     *三方的具体编码继承这个类  
     * 这里的key集合为转换的标准编码
     * @var Array 
     */
    static public $type_maps = [
        self::PAY_TYPE_WECHAT,
        self::PAY_TYPE_ALIPAY,
        self::PAY_TYPE_QQPAY,
        self::PAY_TYPE_BANK  
    ];
    
    
    
    
    
}
