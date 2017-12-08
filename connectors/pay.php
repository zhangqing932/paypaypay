<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './abstractconnector.php';
include_once './monney.php';
include_once './abstractpaytype.php';
include_once './connectors/fuyinbao/sign.php';
class pay extends AbstractConnector{
    
    public function __construct() {
        ;
    }
    public function pay() {
        $this->Monney->conver_unit = Monney::UNIT_FEN;   //在支付之前设置好单位
       $parameter = array(
		'seller_id'         => $this->Merchant,
		'order_type'        => PayType::$type_maps[$this->Pay_type],
		'out_trade_no'      => $this->Order_id,
		'pay_body'          => '我是一个测试啊',
		'total_fee'         => $this->Monney->converFromBase(),
		'notify_url'        => 'http://xxxx.com',
		'return_url'        => 'http://xxxx.com',
		'spbill_create_ip'  => '127.0.0.1',
		'spbill_times'      => time(),
		'noncestr'          => time(),
		'remark'            => time()
	);
       
        $merchant_private_key = openssl_get_privatekey($this->Keys['merchant_private_key']);
        $sign_info ='';
	openssl_sign(sign::getSignStr($parameter),$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
        $parameter['sign'] = base64_encode($sign_info);
        $this->log(self::LOG_TYPE_REQUEST , $parameter );
	$res = $this->http_poststr(json_encode($parameter));
        $resp = json_decode($res , true);
        $this->log(self::LOG_TYPE_RESPONSE , $resp);
        $web_public_key = openssl_get_publickey($this->Keys['server_public_key']);
        $flag = openssl_verify(sign::getSignStr($resp),base64_decode($resp['sign']),$web_public_key,OPENSSL_ALGO_MD5);
        if(!$flag){
            return ;
        }
        switch ($this->Pay_type){
           case PayType::PAY_TYPE_WECHAT:
           case PayType::PAY_TYPE_ALIPAY:
           case PayType::PAY_TYPE_QQPAY:
               $this->output['type'] = self::SHOW_TYPE_IMG;
               $this->output['url']  =  'http://api.xueyuplus.com/wbsp/image_api?text='.$resp['pay_url'];
               break;
           case PayType::PAY_TYPE_BANK: 
                $this->output['type'] = self::SHOW_TYPE_URL;
                $this->output['url'] = $res['pay_url'];
                break;
            
            default :
     
                break;
        }
        return $this->output;
    }
    
    public function callback() {
        $this->input = json_decode($this->input , true);
        $str .= getSignStr($this->input);
        $this->log(self::LOG_TYPE_INPUT);
        $web_public_key = openssl_get_publickey($this->Keys['server_public_key']);
        $flag = openssl_verify($str, base64_decode($this->input['sign']), $web_public_key, OPENSSL_ALGO_MD5);
        if(!$flag){
            $this->error['code'] = 1;
            $this->error['message'] = '签名验证失败';
            $this->log(self::LOG_TYPE_ERROR);
            return 'success';
        }
        $this->Monney               =  new Monney();
        $this->Monney->conver_unit  = $this->Monney_unit;
        $this->Monney->conver_money = $this->input['total_fee'];
        $this->Order_id             = $this->input['out_trade_no'];
        $this->Order_status         = $this->input['pay_status'] == 1?self::ORDER_STATUS_SUCCESS:self::ORDER_STATUS_FILAED; 
        return 'success';
    }
    
  
    public function getOrderId() {
        
        return $this->input['out_trade_no'];
        
    }
    
   public function getOrderMerchant() {
       parent::getOrderMerchant();
       return $this->input['seller_id'];
   }
    
   
   /**
    * @param type $data_string
    * @return type
    */
   function http_poststr($data_string) {
       $this->PayUrl = 'http://api.xueyuplus.com/wbsp/unifiedorder';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, $this->PayUrl);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Content-Length: ' . strlen($data_string))
	);
	$data = curl_exec($ch);
        curl_close($ch);
	return $data;
}
   
    
}

