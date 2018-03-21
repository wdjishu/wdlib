<?php

namespace WDLib\ZK\Handlers;

class EnvHandler
{
	private $file;
	
	public function __construct( $file )
	{
		$this->file = $file;
	}

    function handler( $json )
    {
        $arr = $json ? json_decode( $json, TRUE ) : [];
        if( !$arr ){
        	\Log::error( __METHOD__." env config can not be cleanup" );
        	return;
        }
        $str = '';
        foreach ($arr as $k => $v) {
            $str.="{$k}={$v}\n";
        }
        file_put_contents($this->file, $str);
        unset($json, $arr, $str);
    }
}
