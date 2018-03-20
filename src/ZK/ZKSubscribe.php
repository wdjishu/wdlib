<?php

namespace WDLib\ZK;

class ZKSubscribe extends \Zookeeper
{

    private $callback;

    public function run( $node, $callback )
    {
        $this->callback = $callback;
        $ret = $this->get( $node, [$this, 'watch'] );
        call_user_func( $this->callback, $ret );
    }

    public function watch( $i, $type, $node )
    {
        $ret = $this->get( $node, [$this, 'watch'] );
        call_user_func( $this->callback, $ret );
    }
}
