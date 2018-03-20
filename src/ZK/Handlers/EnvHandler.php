<?php

namespace WDLib\ZK\Handlers;

class EnvHandler
{
	private $file;
	
	public function __construct( $file )
	{
		$this->file = $file;
	}

    function handler( $str )
    {
        if( !$str ){
        	\Log::error( __METHOD__." env config can not be cleanup" );
        	return;
        }
        file_put_contents($this->file, $str);
    }
}
