<?php
class sign{
    
static public function formatBizQueryParaMap($paraMap){
	$buff = "";
	ksort($paraMap);
	foreach ($paraMap as $k => $v)
	{
		if($v != null && $v != ''){
			$buff .= $k . "=" . $v . "&";
		}
	}
	$reqPar = '';
	if (strlen($buff) > 0)
	{
		$reqPar = substr($buff, 0, strlen($buff)-1);
	}
	return urlencode($reqPar);
}

/**
 * 	作用：生成签名
 */
static public function getSignStr($Obj){
	foreach ($Obj as $k => $v)
	{
		if($v != '' && $k != 'sign'){
			$Parameters[$k] = $v;
		}
	}
	ksort($Parameters);
	return urldecode(self::formatBizQueryParaMap($Parameters));
}

static public function array_remove($data, $key){
	if(!array_key_exists($key, $data)){
		return $data;
	}
	$keys = array_keys($data);
	$index = array_search($key, $keys);
	if($index !== FALSE){
		array_splice($data, $index, 1);
	}
	return $data;
}


static public function decodeUnicode($str){
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}
    
    
    
}