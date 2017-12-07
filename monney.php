<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Monney{
    
    const UNIT_LI   = 1;  //厘
    const UNIT_FEN  = 10; //分
    const UNIT_JIAO = 100;//角
    const UNIT_YUAN = 1000;//元
    const UNIT_BASE = 1000;//基础转换单位
    
    public $base_money  =0;                     //基础金额
    public $conver_money=0;                     //转换金额
    public $conver_unit = self::UNIT_BASE;      //转换金额单位
    
    /**
     * 将钱转换为基本单位
     */
    public function converToBase(){
        
        return $this->money = $this->conver_money/$this->conver_unit;
        
    }
    /**
     * 将钱转换成转换金额
     */
    public function converFromBase(){
        
        return $this->conver_money = $this->base_money * $this->conver_unit;
        
    }
    
    
    
    
    
    
    
}

