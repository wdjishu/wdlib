<?php

namespace WDLib\ZK;

class ZKWatcher
{
	private $prefix;
	private $zkConf;
	private $myNodes;
	private $second;

	public function __construct( $prefix, $zkConf, $myNodes, $second=5 )
	{
		$this->prefix  = '/'.trim($prefix, '/');
		$this->zkConf  = $zkConf;
		$this->myNodes = $myNodes;
		$this->second  = $second ? $second : 5;
	}

    public function run()
    {
    	$nodes = include('ZKNodeConf.php');
    	foreach( $this->myNodes as $key => $file ){
    		if( !isset($nodes[$key]) ){
    			continue;
    		}
    		$node   = $this->prefix.$key;
    		$class  = __NAMESPACE__.'\\Handlers\\'.$nodes[$key];
    		$objCb  = new $class( $file );
    		$objSub = new ZKSubscribe( $this->zkConf );
    		$objSub->run( $node, [ $objCb, 'handler'] );
    	}
    	while( true ){
    		sleep( $this->second );
    	}
    }
}
