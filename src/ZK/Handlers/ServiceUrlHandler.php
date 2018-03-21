<?php

namespace WDLib\ZK\Handlers;

class ServiceUrlHandler
{
	private $file;
	
	public function __construct( $file )
	{
		$this->file = $file;
	}

    function handler( $str )
    {
        $arr = json_decode( $str , TRUE );
        if( !is_array( $arr ) ){
        	\Log::error( __METHOD__." config error." );
        	return;
        }
        $str = "<?php\n return ".var_export( $arr, TRUE ).';';
        file_put_contents($this->file, $str);
    }
}
