<?php

namespace WDLib\ZK;

class ZKWatcher
{
	private $platform;
	private $zkConf;
	private $myNodes;
	private $second;

    private $nodes = [
        'NODE_ENV_UNION_BASE' => '/env/union.base',
        'NODE_SERVICE_URLS'   => '/service/urls',
    ];
    private $handlers = [
        'NODE_ENV_UNION_BASE' => __NAMESPACE__.'\\Handlers\\EnvHandler',
        'NODE_SERVICE_URLS'   => __NAMESPACE__.'\\Handlers\\ServiceUrlHandler',
    ];

	public function __construct($platform, $zkConf, $myNodes, $second=5 )
	{
		$this->platform = '/'.trim( $platform, '/');
		$this->zkConf   = $zkConf;
		$this->myNodes  = $myNodes;
		$this->second   = $second;
	}

    public function run()
    {
        if( '/'==$this->platform || empty($this->zkConf) || empty($this->myNodes) ){
            return FALSE;
        }
    	foreach( $this->myNodes as $key => $file ){
    		if( !isset($this->nodes[$key]) || !isset($this->handlers[$key]) ){
    			continue;
    		}
    		$node   = $this->platform.$this->nodes[$key];
    		$class  = $this->handlers[$key];
    		$objCb  = new $class( $file );
    		$objSub = new ZKSubscribe( $this->zkConf );
    		$objSub->run( $node, [ $objCb, 'handler'] );
    	}
    	while( $this->second > 0 ){
    		sleep( $this->second );
    	}
    }
}
