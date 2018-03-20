<?php

namespace WDLib\MS;

use GuzzleHttp\Client as HttpClient;

class MSHttp extends HttpClient
{
	public function call( $key, $params )
	{
		$data   = [];
		$method = substr( $url, 0, strpos($url, '.'));
		$url    = $this->makeUrl( $key, $params );
		switch ( $method ) {
			case 'GET':
				$data['query'] = $params;
				break;
			case 'PUT':
				$data['form_params'] = $params;
				break;
			case 'POST':
				$data['form_params'] = $params;
				break;
		}
		$response = $this->request( $method, $url, $data );
		$code     = $response->getStatusCode();
		$retJson  = $response->getBody();
		return $retJson;
	}

	private function makeUrl( $key, &$params )
	{
		$arrMSUrl = config('msurl');
		$url      = $arrMSUrl[ $key ];
		preg_match_all('/\{(\w+)\}/', $url, $match);
		if( empty($match[1]) ){
			return $url;
		}

		$replace = [];
		foreach( $match[1] as $k ){
			$replace[$k] = $params[$k];
			unset( $params[$k] );
		}
		$url = str_replace($match[0], $replace, $url);
		return $url;
	}
}