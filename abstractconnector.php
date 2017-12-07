<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 规范链接的接口数据(输入,输出)和方法
 * pay 和callback 是一对方法 除了订单号和金额之外的其他校验数据均在这两个方法中生成和校验
 */

abstract  class AbstractConnector{
    
    
    /**
     * 支付账号
     * @var mixed 
     */
    public $Merchant;
    
    /**
     * 签名类型
     * @var mixed 
     */
    public $Sing_type;
    
    /**
     * 签名的key
     * @var Array 
     */
    public $Keys = [
        'md5'=>'',                  //md5 模式的key
        'merchant_private_key'=>'', //商户私钥
        'merchant_public_key'=>'',  //商户公钥
        'server_public_key'=>''     //服务商公钥
    ];
    /**
     * 支付金额对象
     * @var Monney
     */
    public $Monney;
    
    /**
     * 订单号
     * @var type 
     */
    public $Order_id; 
    
    /**
     * 支付的类型
     * @var int 
     */
    public $Pay_type;
    
    const ORDER_STATUS_SUCCESS = 1;
    const ORDER_STATUS_FILAED  = 2;
    /**
     * 支付的状态
     * @var type 
     */
    public $Order_status;
    
    
    
    /**
     * 输入数据
     * @var mixed 
     */
    public $input ;
    /**
     * 输出数据
     * @var Array
     */
    public $output = [
        'type'=>"",     //展示类型  1 为图片展示 2为网址跳转  3为数据输出(键值对,前端业务用自动提交的方式)
        'url'=>'',      //跳转的地址
        'data'=>'',      //展示的数据
        'post'=>true //提交类型
    ];
    const SHOW_TYPE_IMG     = 1;
    const SHOW_TYPE_URL     = 2;
    const SHOW_TYPE_FROM    = 3;
    
    public $error = [
        'code',
        'message'
    ];
    
    /**
     * 支付接口
     */
    abstract  public function pay();
    
    
    /**
     * 回调解析接口
     */
    abstract  public function callback();
    
    /**
     * 数据解析之前可能需要通过账号 取得key
     */
    public function getOrderId(){
        
    }
    /**
     * 数据解析之前可能需要通过账号 取得key
     */
    public function getOrderMerchant(){
        
    }
    
    const LOG_TYPE_INPUT  = 1; //输入类型
    const LOG_TYPE_OUTPUT = 2; //输出类型
    const LOG_TYPE_ERROR  = 4; //错误类型(业务错误) 
    const LOG_TYPE_REQUEST = 8; //服务器内部请求
    const LOG_TYPE_RESPONSE = 16; //请求返回值
    
    /**
     * 记录输入输出日志
     * 如果需要存储,请覆盖此方法
     */
    public function log($type , $data = null){
        if($type == self::LOG_TYPE_INPUT){
           $log_file = './logs/input.log';
           $data = $this->input;
        }elseif ($type == self::LOG_TYPE_OUTPUT) {
           $log_file = './logs/output.log'; 
           $data = $this->output;
        }elseif($type == self::LOG_TYPE_ERROR){
            $log_file = './logs/error.log';
            $data = $this->error; 
        }elseif($type == self::LOG_TYPE_REQUEST){
            $log_file = './logs/request.log';
            $data = $data;
        }else{
             $log_file = './logs/response.log';
             $data = $data;
        }
        $data = date('Y-m-d H:i:s').'  '.self::class .':'.var_export($data , true).PHP_EOL;
        file_put_contents($log_file, $data  , FILE_APPEND); 
    }
    /**
     * 当接收到第三方回调的时候 需回调一下业务层
     */
    public function Closure_func(){
        
        
    }
    
    
}

